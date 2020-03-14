"use strict";
import {httpPostRequestAsync, getUrlAnchor} from '/js/common.mjs'


function alertUserOfUploadStatus(data)
{
	const note = document.getElementById("note");

	// Add message
	note.querySelector("#note-message").innerHTML = data["message"];

	// Change class depending on if successful or not
	let alert_class = note.getAttribute("class");
	if (data["ok"] === true)
	{
		note.querySelector("#note-submessage").innerHTML =
			`Access your file <a href=${data["path"]}>here</a>`;
	}
	note.setAttribute("class", alert_class);

	// Display
	note.removeAttribute("hidden");
}

async function upload()
{
	let file = document.getElementById("file-input").files[0];
	let form_data = new FormData();

	form_data.append("file_to_upload", file);
	fetch('/cms/api/private/upload.php', {method: "POST", body: form_data})
		.then(function(response) {
			response.text().then(function(text) {
				console.log(text);
				let data = JSON.parse(text);
				alertUserOfUploadStatus(data);


			});
		});
}
document.querySelector("#upload-button").onclick =  upload;
