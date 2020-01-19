"use strict";
import {httpGetRequestAsync, getUrlAnchor} from '/js/common.mjs'
const snips = {
"default":"cover.html",
"experience":"experience.html",
"skills":"skills.html"
};

// Adjust content according to URL
async function adjustContent()
{
	let anchor = getUrlAnchor();
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

	let nav_links = document.getElementsByClassName("nav-link");
	for (let link of nav_links)
	{
		link.className="nav-link";
	}
	document.getElementById("link-"+anchor).className="nav-link active"
}
adjustContent();
window.onhashchange = adjustContent;
