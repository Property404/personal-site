"use strict";
import {httpPostRequestAsync, getUrlAnchor} from '/js/common.mjs'

export async function deletePost()
{
	const post_id = getUrlAnchor();
	let res = await httpPostRequestAsync("/cms/api/private/delete_post.php",
	{
			"id":post_id
		});
	console.log(res);
	res = JSON.parse(res);
	console.log(res["ok"])
	if(res["ok"])
		removePostEntry(post_id);
}

function removePostEntry(id)
{
	let entry = document.querySelector("#entry-"+id);
	entry.remove();
}
function addPostEntry(post)
{
	let post_list_div = document.querySelector("#post-entries");
	let template = document.querySelector("#post-entry-template");
	let item = template.cloneNode(true);
	item.setAttribute("id", "entry-"+post["id"]);
	item.removeAttribute("hidden");
	item.querySelector("#title").innerHTML = post["title"]
	item.querySelector("#delete-link").setAttribute("href", "#"+post["id"]);
	item.querySelector("#edit-link").setAttribute("href", "?panel=edit&id="+post["id"]);
	post_list_div.appendChild(item);
}
async function fillPostEntries()
{
	const post_result = await httpPostRequestAsync("/cms/api/public/get_posts.php", {});
	console.log(post_result);
	const list = JSON.parse(post_result)["posts"];
	for(let post of list)
	{
		addPostEntry(post)
	}

}

fillPostEntries();

document.querySelector("#confirm_delete_button")
	.addEventListener('click', deletePost);
