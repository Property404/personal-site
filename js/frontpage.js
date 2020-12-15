"use strict";
const snips = {
"cover":"cover.html",
"projects":"projects.html",
"experience":"experience.html",
"skills":"skills.html",
"http_error":"http_error.php",
};

// Hacks to reduce latency for high-latency connections
// (Tor Browser)
async function cacheFetchPages()
{
	for(const snip in snips)
	{
		const page = snips[snip];
		if(page.endsWith(".html"))
			fetch("/snips/"+page+"?page="+snip);
	}

}

// Adjust content according to URL
export async function adjustContent(dry=false)
{
	const url_query = window.location.search;
	const url_parameters = new URLSearchParams(url_query);

	let anchor = url_parameters.get("page");
	if(anchor === null && !document.querySelector("#http-error"))
		anchor="cover";
	const snip = snips[anchor]

	if(!snip)
	{
		console.log("Note: no dynamic content replacement");
		console.log(anchor);
	}


	// Fetch page content
	if(!dry)
	{
		const url = "/snips/"+snip+url_query
		fetch(url)
			.then((response)=>response.text())
			.then(function(text){
				document.getElementById("content").innerHTML = text;
			});
	}

	// Dehighlight all menu 
	const nav_links = document.getElementsByClassName("nav-link");
	for (const link of nav_links)
	{
		link.className="nav-link";
	}

	// Highlight/Underscore selected page in menu
	const active_link = document.getElementById("link-"+anchor);
	if(active_link)
		active_link.className="nav-link active"
}

// Get rid of GET parts of URL links
// Since we have javascript, we're not using the PHP fallback
// that sends us to a new page
// This makes for a lighter, faster user experience(hopefully)
const nav_links = document.getElementsByClassName("nav-link");
for (const link of nav_links)
{
	link.onclick = function(new_entry){
		history.pushState(null,'',new_entry);
		adjustContent()
	}.bind(null,link.href+"#");

	link.href = "#"; 
}
adjustContent(true);
cacheFetchPages();
