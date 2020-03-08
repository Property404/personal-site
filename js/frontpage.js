"use strict";
import {httpGetRequestAsync, parseUrlParameters} from '/js/common.mjs'
const DEFAULT_PAGE = "cover.html"
const snips = {
"default":"cover.html",
"experience":"experience.html",
"skills":"skills.html"
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

	const content = await httpGetRequestAsync("/snips/"+snip);
	document.getElementById("content").innerHTML = content;

	// Highlight selected branch
	let nav_links = document.getElementsByClassName("nav-link");
	for (let link of nav_links)
	{
		link.className="nav-link";
	}
	document.getElementById("link-"+anchor).className="nav-link active"
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
