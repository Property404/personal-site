"use strict";
import {httpPostRequestAsync, getUrlAnchor} from '/js/common.mjs'

export async function deleteBlog()
{
	const post_id = getUrlAnchor();
	let res = await httpPostRequestAsync("/cms/api/private/delete_blog.php",
		{
			"id":post_id
		});
	console.log(res);
	res = JSON.parse(res);
	console.log(res["ok"])
	if(res["ok"])
		removeBlogEntry(post_id);
}

export async function addBlog()
{
	const blog_name = document.querySelector("#new_blog_name").value;
	const result = await httpPostRequestAsync("/cms/api/private/create_blog.php",
		{
			"blog_name":blog_name
		});
	console.log(result);
	addBlogEntry(JSON.parse(result));

}

function removeBlogEntry(id)
{
	let blog_list_div = document.querySelector("#blog_list");
	let entry = document.querySelector("#entry-"+id);
	entry.remove();
}
function addBlogEntry(blog)
{
	let blog_list_div = document.querySelector("#blog_list");
	let template = document.querySelector("#blog-entry-template");
	let item = template.cloneNode(true);
	item.setAttribute("id", "entry-"+blog["id"]);
	item.removeAttribute("hidden");
	item.querySelector("#name").innerHTML = blog["name"]
	item.querySelector("#delete-link").setAttribute("href", "#"+blog["id"]);
	blog_list_div.appendChild(item);
}
async function fillBlogEntries()
{
	const post_result = await httpPostRequestAsync("/cms/api/public/get_blogs.php", {});
	console.log(post_result);
	const list = JSON.parse(post_result)["blogs"];
	for(let blog of list)
	{
		addBlogEntry(blog)
	}

}

fillBlogEntries();

document.querySelector("#confirm_delete_button")
	.addEventListener('click', deleteBlog);

document.querySelector("#confirm_add_button")
	.addEventListener('click', addBlog);
