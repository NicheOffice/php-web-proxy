<?php

use Proxy\Config;

// escape a value for safe output inside HTML text and attributes
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// true only for globally routable addresses (no loopback, private, link-local, reserved...)
function is_public_ip($ip)
{
    return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_GLOBAL_RANGE) !== false;
}

// all IPv4 and IPv6 addresses a host name resolves to
function resolve_host($host)
{
    if (filter_var($host, FILTER_VALIDATE_IP)) {
        return array($host);
    }

    $ips = gethostbynamel($host) ?: array();

    $records = @dns_get_record($host, DNS_AAAA);
    foreach ((array)$records as $record) {
        if (isset($record['ipv6'])) {
            $ips[] = $record['ipv6'];
        }
    }

    return array_values(array_unique($ips));
}

/*
Makes sure the URL we are about to fetch is a plain http(s) URL on the public internet.
Without this anyone could read local files (file:///etc/passwd) or reach services
only the server itself can see (http://127.0.0.1, cloud metadata at 169.254.169.254...).
Throws an Exception describing the problem.
*/
function validate_target_url($url)
{
    $parts = parse_url($url);

    if ($parts === false || empty($parts['host'])) {
        throw new Exception("Invalid URL: " . $url);
    }

    $scheme = strtolower(isset($parts['scheme']) ? $parts['scheme'] : '');

    if ($scheme !== 'http' && $scheme !== 'https') {
        throw new Exception("Only http:// and https:// URLs are supported.");
    }

    if (!Config::get('block_private_networks', true)) {
        return;
    }

    // [::1] -> ::1
    $host = trim($parts['host'], '[]');
    $ips = resolve_host($host);

    if (!$ips) {
        throw new Exception("Could not resolve host: " . $host);
    }

    foreach ($ips as $ip) {
        if (!is_public_ip($ip)) {
            throw new Exception("Access to private or local network addresses is not allowed.");
        }
    }

    // pin cURL to the addresses we just checked so a second DNS lookup cannot point somewhere else
    $port = isset($parts['port']) ? $parts['port'] : ($scheme === 'https' ? 443 : 80);
    $addresses = array_map(function ($ip) {
        return strpos($ip, ':') !== false ? "[{$ip}]" : $ip;
    }, $ips);

    Config::set('curl', array_merge_custom(Config::get('curl', array()), array(
        CURLOPT_RESOLVE => array("{$parts['host']}:{$port}:" . implode(',', $addresses))
    )));
}
