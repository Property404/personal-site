"use strict";
const snips = {
	"index":"index.html",
	"projects":"projects.html",
	"experience":"experience.html",
	"skills":"skills.html",
	"http_error":"http_error.php",

};

const cache = {
};

// Load all snips to reduce apparent latency
async function cacheFetchPages()
{
    const promises = []
	for(const snip in snips)
	{
		const page = snips[snip];
		if(page.endsWith(".html")) {
            console.log("Caching "+page)
            promises.push(
                fetch("/snips/"+page)
                .then((response)=>response.text())
                .then((response)=>{cache[page] = response})
            );
        }
	}
    await Promise.all(promises);

}

// Adjust content according to URL
function adjustContent()
{
    const pathname = window.location.pathname;
    let page = pathname.substring(1);
    if (page == "") {
        page = "index.html"
    }
    const content = cache[page];
    document.getElementById("content").innerHTML = content;

	// Dehighlight all menu
    const snip = page.replace(".html","")
	const nav_links = document.getElementsByClassName("nav-link");
	for (const link of nav_links)
	{
        if (link.id === "link-"+snip) {
            link.className="nav-link active";
        } else {
            link.className="nav-link";
        }
	}
}

async function main() {
    await cacheFetchPages();

    // Set links to load from cache, hopefully making this experience snappier
    const nav_links = document.getElementsByClassName("nav-link");
    for (const link of nav_links)
    {
        link.onclick = function(new_entry){
            // TODO: Make pressing back not annoying
            history.replaceState(null,"",new_entry);
            adjustContent();
        }.bind(null,link.href);
        link.href = "#";
    }
}

main()
