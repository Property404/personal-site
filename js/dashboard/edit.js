"use strict";
import {httpPostRequestAsync, parseUrlParameters} from '/js/common.mjs'


async function fillFields(id)
{
	const raw_json_text = await getPostData(id);
	const post = JSON.parse(raw_json_text);
	document.querySelector("#title").value = post["title"];
	document.querySelector("#blurb").innerHTML = post["blurb"];
}
async function getPostData(id)
{
	return await fetch("/cms/api/public/get_post.php?id="+id,
		{method:"GET"})
		.then(function(response) {
				return response.text()
		});
}

let id = parseUrlParameters()["id"]; 
if(id)
	fillFields(id);
