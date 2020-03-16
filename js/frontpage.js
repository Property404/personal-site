"use strict";
import {httpGetRequestAsync, getUrlGETQuery, parseUrlParameters} from '/js/common.mjs'
const DEFAULT_PAGE = "cover.html"
const snips = {
"cover":"cover.html",
"experience":"experience.html",
"skills":"skills.html",
"blog":"blog.php",
"post":"post.php",
"http_error":"http_error.php",
};

// Hacks to reduce latency for high-latency connections
// (Tor Browser)
async function cacheFetchPages()
{
	for(let snip in snips)
	{
		const page = snips[snip];
		if(page.endsWith(".html"))
			httpGetRequestAsync("/snips/"+page+"?page="+snip);
	}

}

// Adjust content according to URL
export async function adjustContent(dry=false)
{
	let anchor = parseUrlParameters()["page"];
	if(anchor === undefined && !document.querySelector("#http-error"))
		anchor="cover";
	let snip = snips[anchor]

	if(!snip)
	{
		console.log("Note: not replacing content dynamically");
		console.log(anchor);
		return;
	}

	// Fetch page content
	if(!dry)
	{
		httpGetRequestAsync("/snips/"+snip+getUrlGETQuery()).then((content)=>
			{document.getElementById("content").innerHTML = content});
	}

	// Dehighlight all menu items
	let nav_links = document.getElementsByClassName("nav-link");
	for (let link of nav_links)
	{
		link.className="nav-link";
	}

	// Highlight "blog" when on any blog post
	if(anchor=="post")anchor="blog";

	// Highlight/Underscore selected page in menu
	let active_link = document.getElementById("link-"+anchor);
	if(active_link)
		active_link.className="nav-link active"
}

// Get rid of GET parts of URL links
// Since we have javascript, we're not using the PHP fallback
// that sends us to a new page
// This makes for a lighter, faster user experience(hopefully)
let nav_links = document.getElementsByClassName("nav-link");
for (let link of nav_links)
{

	link.setAttribute("meta",link.href+"#");

	link.onclick = function(){
		history.pushState(null,'',this.getAttribute("meta"));
		adjustContent()
	}
	link.href = "#"; 
}
adjustContent(true);
cacheFetchPages();
