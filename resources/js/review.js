(function (headings, reviews) {
    // TOC Watcher 
    let headingsObserver = new IntersectionObserver(entries => {
        entries.map(({ isIntersecting, target }) => {
            let tocLinks = document.querySelectorAll(`.toc-content a[href="#${target.id}"]`);
            if (isIntersecting) {
                tocLinks.forEach(el => el.parentElement.classList.add("toc-link-active"));
            }
            else {
                tocLinks.forEach(el => el.parentElement.classList.remove("toc-link-active"));
            }
        })
    },
        {
            threshold: 1,
        }
    );
    headings.forEach(el => headingsObserver.observe(el));
    
    // CheckPrice Bottom Div 
    let checkPriceBottom = document.createElement('div');
    checkPriceBottom.setAttribute("class", "check-price-bottom hidden w-full bg-white h-16 bg-opacity-90 shadow");

    let cookieToggle = document.querySelector("div.js-cookie-consent.cookie-consent");

    if (cookieToggle === null) {
        checkPriceBottom.setAttribute("style", "bottom:0px;z-index:50;");
    }
    else {
        cookieToggle.querySelector("button.js-cookie-consent-agree.cookie-consent__agree").addEventListener("click", () => {
            document.querySelector(".check-price-bottom").setAttribute("style", "bottom:0px;z-index:50;");
        });
    }

    let checkPriceBottomWrapper = checkPriceBottom.appendChild(document.createElement("div"));
    checkPriceBottomWrapper.setAttribute("class", "w-full h-full max-w-6xl mx-auto px-4");

    let checkPriceBottomContainer = checkPriceBottomWrapper.appendChild(document.createElement("div"));
    checkPriceBottomContainer.setAttribute("class", "flex h-full items-center justify-content-center justify-between mx-8 font-semibold");

    let checkPriceBottomImage = checkPriceBottomContainer.appendChild(document.createElement("img"));
    checkPriceBottomImage.setAttribute("class", "lazyload");
    checkPriceBottomImage.dataset.src = reviews[0].dataset.image;
    checkPriceBottomImage.alt = reviews[0].dataset.title;
    checkPriceBottomImage.width = 50;
    checkPriceBottomImage.height = 50;

    let checkPriceBottomTitle = checkPriceBottomContainer.appendChild(document.createElement("p"));
    checkPriceBottomTitle.setAttribute("class", "title text-lg lg:text-xl truncate overflow-hidden")
    checkPriceBottomTitle.title = reviews[0].dataset.title;

    let checkPriceBottomUrl = checkPriceBottomContainer.appendChild(document.createElement("a"));
    checkPriceBottomUrl.setAttribute("class", "px-4 py-3 bg-red-800 text-lg text-white truncate overflow-hidden");
    checkPriceBottomUrl.href = reviews[0].dataset.url;
    checkPriceBottomUrl.textContent = "Check Price";

    let footer = document.querySelector("footer");
    footer.parentNode.appendChild(checkPriceBottom);

    let reviewsObserver = new IntersectionObserver(entries => {
        entries.map(({ isIntersecting, target }) => {
            let node = document.querySelector(".check-price-bottom");
            if(isIntersecting && node){
                    // Reanimate div with cloning it.
                    node.querySelector("img").src = "";       
                    node.querySelector("img").classList.remove("lazyloaded");       
                    node.querySelector("img").classList.add("lazyload");       
                    node.querySelector("img").dataset.src = target.dataset.image;          
                    node.querySelector("img").alt = target.dataset.title;          
                    node.classList.add("check-price-bottom-animate");
                    node.querySelector("p.title").textContent = target.dataset.title;
                    node.querySelector("a").href = target.dataset.url;
                    node.classList.remove("hidden");
                    node.classList.add("sticky");

                    let newNode = node.cloneNode(true);
                    node.parentNode.replaceChild(newNode, node);
            }
            })
        }
    );

    // Add check price section to .review classes' end
    let reviewsLength = reviews.length;

    for (let i = 0; i < reviewsLength; i++) {
        // This is for CheckPriceBotoomDiv
        reviewsObserver.observe(reviews[i]);

        let review_url = reviews[i].dataset.url;
        let review_title = reviews[i].dataset.title;
        let review_image = reviews[i].dataset.image;

        
        
        // Wrap images with a tag
        let img = reviews[i].querySelector("img");
        img.alt = reviews[i].dataset.title;

        if(img){
            let link = document.createElement('a');
            link.href = review_url;

            img.parentNode.insertBefore(link, img);

            link.appendChild(img);
        }

        let checkprice = '<div class="checkprice"><div class="image"><img width="400" height="400" class="lazyload" data-src="' + review_image + '" alt="' + review_title + '" /></div><div class="title">' + review_title + '</div><div class="url"><a href="' + review_url + '">Check Price</a></div></div>';
        
        checkpriceNode = document.createRange().createContextualFragment(checkprice);

        reviews[i].appendChild(checkpriceNode);
    }

    //Add noopener to all external links
    document.querySelectorAll("a").forEach(link => {
        if (link.href.indexOf(window.location.origin) && link.href){
            link.rel = "noopener";
        }
    });

})(
    document.querySelectorAll(".content h1[id],h2[id],h3[id],h4[id],h5[id],h6[id]"),
    document.querySelectorAll(".content .review")
    )
