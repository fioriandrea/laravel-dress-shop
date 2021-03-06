const makeReviewStars = (stars, hidden) => {
    if (!stars || !hidden)
        return;
    const updateStars = (i) => {
        hidden.value = i + 1;
        for (let j = 0; j <= i; j++) {
            stars.children[j].classList.add("checked");
        }
        for (let j = i + 1; j < stars.children.length; j++) {
            stars.children[j].classList.remove("checked");
        }
    };
    updateStars(+stars.dataset.reviewstars - 1);
    for (let i = 0; i < stars.children.length; i++) {
        stars.children[i].addEventListener("click", () => {
            stars.dataset.reviewstars = i + 1;
            updateStars(+stars.dataset.reviewstars - 1);
        });
    }
};

const setAvailableParagraph = (p, available) => {
    p.classList.remove("text-danger");
    p.classList.remove("text-warning");
    p.classList.remove("fw-light");
    if (available === 0) {
        p.innerText = "Not available at the moment";
        p.classList.add("text-danger");
    } else {
        p.innerText = `${available} article${available > 1 ? "s" : ""} left`;
        if (available <= 3) {
            p.classList.add("text-warning");
        } else {
            p.classList.add("fw-light");
        }
    }
};

const setShippingParagraph = (p, shipping) => {
    p.classList.remove("fw-light");
    p.classList.remove("text-success");
    if (shipping === 0) {
        p.innerText = "Free shipping";
        p.classList.add("text-success");
    } else {
        p.innerText = `+${shipping} EUR for shipping`;
        p.classList.add("fw-light");
    }
};

document.querySelectorAll("[data-available]").forEach((element) => {
    setAvailableParagraph(element, +element.dataset.available);
});

document.querySelectorAll("[data-shipping]").forEach((element) => {
    setShippingParagraph(element, +element.dataset.shipping);
});

const tag = (tagname, props = {}, children = []) => {
    const element = document.createElement(tagname);
    for (let prop in props) {
        if (!props.hasOwnProperty(prop))
            continue;
        const val = props[prop];
        if (prop.startsWith('on') && prop in window) {
            element.addEventListener(prop.substr(2), val);
            continue;
        }
        element.setAttribute(prop, val.toString())
    }   
    children.forEach((child) => {
        element.appendChild(child.nodeType === undefined ? 
            document.createTextNode(child.toString()) :
            child);
    }); 
    return element;
};

const createAlertAjax = (message, type = "success") => {
    return tag("div", {class: `alert alert-${type} text-center msg`}, [
        tag("strong", {}, [message]),
    ]);
};

const kebabToCamel = (str) => {
    return str.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
};

const createAjaxDelete = (buttonDataStr, cardDataStr) => {
    return () => {
        const alertAjax = document.querySelector("#alert-ajax");
        const buttons = document.querySelectorAll(`[data-${buttonDataStr}]`);
        buttons.forEach(button => {
            button.addEventListener("click", (event) => {
                event.preventDefault();
                alertAjax.innerHTML = "";
                const form = button.parentElement;
                const id = button.dataset[kebabToCamel(buttonDataStr)];
                const card = document.querySelector(`[data-${cardDataStr}="${id}"]`);
                const formData = new FormData(form);
                fetch(form.action, {
                    method: "POST",
                    body: formData,
                }).then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                }).then(json => {
                    alertAjax.appendChild(createAlertAjax(json.message, json.success ? "success" : "danger"));
                    if (json.success) {
                        card.remove();
                    }
                }).catch(error => {
                    alertAjax.appendChild(createAlertAjax(error, "error"));
                });
            });
        });
    };
};

const paginate = (parent, itemsPerPage = 5, maxButtons = 5, initialPage = 0) => {
    const paginationNav = document.querySelector("#pagination-nav");
    if (!paginationNav) {
        throw new Error("No pagination nav found");
    }
    function formatPage(page) {
        paginationNav.innerHTML = "";
        const items = Array.from(parent.children);
        const pages = Math.ceil(items.length / itemsPerPage);
        page = Math.max(0, Math.min(page, pages - 1));
        parent.dataset.currentPage = page;
        const startItem = page * itemsPerPage;
        const endItem = Math.min(startItem + itemsPerPage, items.length);
        items.forEach((child, i) => {
            child.hidden = !(i >= startItem && i < endItem);
        });
        if (items.length > itemsPerPage) {
            const paginationList = createPaginationList(pages, page);
            paginationNav.appendChild(paginationList);
        }
    };
    function createPaginationList(pages, currentPage) {
        const createButton = (text) => {
            return tag("li", { class: "page-item" }, [
                tag("button", { class: "page-link" }, [text]),
            ]);
        };
        const list = tag("ul", { class: "pagination" });
        const prev = createButton("<");
        prev.addEventListener("click", (event) => {
            event.preventDefault();
            if (currentPage > 0) {
                currentPage--;
                formatPage(currentPage);
            }
        });
        list.appendChild(prev);
        const startButton = Math.max(0, currentPage - Math.floor(maxButtons / 2));
        const endButton = Math.min(currentPage + Math.floor(maxButtons / 2), pages - 1);
        for (let i = startButton; i <= endButton; i++) {
            const li = createButton(i + 1);
            li.addEventListener("click", (event) => {
                event.preventDefault();
                formatPage(i);
            });
            if (i === currentPage) {
                li.classList.add("active");
            }
            list.appendChild(li);
        }
        const succ = createButton(">");
        succ.addEventListener("click", (event) => {
            event.preventDefault();
            if (currentPage < pages - 1) {
                currentPage++;
                formatPage(currentPage);
            }
        });
        list.appendChild(succ);
        return list;
    };
    formatPage(initialPage);

    const obs = new MutationObserver(() => {
        formatPage(parent.dataset.currentPage || 0);
    });
    obs.observe(parent, {
        childList: true,
    });

    const res = {
        get itemsPerPage() {
            return itemsPerPage;
        },
        set itemsPerPage(ipp) {
            itemsPerPage = Math.max(0, ipp);
            formatPage(parent.dataset.currentPage);
        },
        get maxButtons() {
            return maxButtons;
        },
        set maxButtons(mbs) {
            maxButtons = Math.max(0, mbs);
            formatPage(parent.dataset.currentPage);
        },
    };

    return res
};