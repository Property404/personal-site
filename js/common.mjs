"use strict";
const HTTP_STATUS_OK = 200;


export function getUrlAnchor()
{
	const query = window.location.hash;
	return query.substring(query.indexOf("#")+1);
}

export function getUrlGETQuery()
{
	return window.location.search;
}
// Parse GET parameters in URL
// Returns a dict
export function parseUrlParameters(){
	const query = window.location.search.substring(1);
	const pl     = /\+/g;  // Regex for replacing addition symbol with a space
	const search = /([^&=]+)=?([^&]*)/g;

	let decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); }
	let url_params = {};
	let match;

	while (match = search.exec(query))
	{
		url_params[decode(match[1])] = decode(match[2]);
	}
	return url_params;
}

export function httpGetRequestAsync(url)
{
	return new Promise(function(resolve, reject){
		const xhr = new XMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onload = ()=>{
			if(xhr.status == HTTP_STATUS_OK)
				resolve(xhr.responseText);
			else
				reject(Error("Status "+xhr.status));
		}
		xhr.send();
	});
}

export function httpPostRequestAsync(url, parameters)
{
	return new Promise(function(resolve, reject){
		const xhr = new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = ()=>{
			if(xhr.status == HTTP_STATUS_OK)
				resolve(xhr.responseText);
			else
				reject(Error("Status "+xhr.status));
		}
		const parsed_params = Object.entries(parameters).
			map(([key, val]) => `${key}=${val}`).join('&');
		xhr.send(parsed_params);
	});
}
