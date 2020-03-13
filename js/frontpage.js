"use strict";
import {httpGetRequestAsync, getUrlGETQuery, parseUrlParameters} from '/js/common.mjs'
const DEFAULT_PAGE = "cover.html"
const snips = {
"default":"cover.html",
"experience":"experience.html",
"skills":"skills.html",
"blog":"blog.php",
"post":"post.php",
};

// Adjust content according to URL
export async function adjustContent()
{
	let anchor = parseUrlParameters()["page"];
	let snip = snips["default"];

	if (snips[anchor])
	{
		snip = snips[anchor];
	}
	else
	{
		anchor="default";
	}

	// Fetch page content
	const content = await httpGetRequestAsync("/snips/"+snip+getUrlGETQuery());
	document.getElementById("content").innerHTML = content;

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
		history.replaceState(null,'',this.getAttribute("meta"));
		adjustContent()
	}
	link.href = "#"; 
}

adjustContent();
