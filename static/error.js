"use strict";

const MESSAGES = {
    "400":"Bad Request",
    "401":"Unauthorized",
    "402":"Payment Required",
    "403":"Forbidden",
    "404":"Not Found",
    "405":"Method Not Allowed",
    "406":"Not Acceptable",
    "407":"Proxy Authentication Required",
    "408":"Request Timeout",
    "409":"Conflict",
    "410":"Gone",
    "411":"Length Required",
    "412":"Precondition Failed",
    "413":"Request Entity Too Large",
    "414":"Request URI Too Large",
    "415":"Unsupported Media Type",
    "416":"Range Not Satisfiable",
    "417":"Expectation Failed",
    "418":"I'm a Teapot",
    "421":"Misdirected Request",
    "422":"Unprocessable Entity",
    "423":"Locked",
    "424":"Failed Dependency",
    "425":"Too Early",
    "426":"Upgrade Required",
    "429":"Too Many Requests",
    "494":"Request Header Too Large",
    "495":"SSL Certificate Error",
    "497":"HTTP Request Sent to HTTPS Port",
    "499":"Client Closed Request",
    "500":"Internal Server Error",
    "501":"Not Implemented",
    "502":"Bad Gateway",
    "503":"Service Unavailable",
    "504":"Gateway Timeout",
    "505":"HTTP Version Not Supported",
    "507":"Insufficient Storage",
    "508":"Loop Detected",
    "511":"Network Authentication Required",
};
const SUBMESSAGES = {
    "402":"I wouldn't want to have to break your legs...",
    "403":"The police are on their way",
    "404":"I hope in the future you are able to find what you're looking for",
    "406":'<video height="315" src="/media/videos/406.mp4" controls></video>',
    "410":"Poof. Gone. Vanished.",
    "411":"If you know what I'm saying ;)",
    "418":"This error should never come up, considering that this website runs on a rice cooker",
    "425":"Don't worry, it happens to a lot of guys",
    "500":"Have a pint and wait for this to blow over",
    "503":"Hopefully service will be back shortly",
    "507":"I couldn't eat another thing. I'm absolutely stuffed"
};
const url = new URL(window.location.href);
const params = new URLSearchParams(url.search);
const code = params.get('code');
const message = MESSAGES[code];
const submessage = SUBMESSAGES[code] ?? "";

document.getElementById("http-error").textContent = message ? (code + " - "+message) : ("Error - " + code);
document.getElementById("http-error-submessage").innerHTML = submessage;
