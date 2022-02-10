const makeReviewStars = (stars, hidden) => {
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


const formatCardNumber = (value, delim = ' ') => {
    const res = [];
    for (let i = 0; i < value.length; i++) {
        if (i % 4 === 0 && i !== 0) {
            res.push(delim);
        }
        res.push(value[i]);
    }
    return res.join('');
};

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
                    alertAjax.appendChild(createAlertAjax(error));
                });
            });
        });
    };
};

const paginate = (parent, itemsPerPage = 5, maxButtons = 3) => {
    const items = Array.from(parent.children);
    const paginationNav = document.querySelector("#pagination-nav");
    if (!paginationNav) {
        throw new Error("No pagination nav found");
    }
    paginationNav.innerHTML = "";
    if (items.length <= itemsPerPage) {
        return;
    }
    const buttons = [];
    let currentPage = 0;
    const formatPage = (page) => {
        parent.innerHTML = "";
        const startItem = page * itemsPerPage;
        const endItem = Math.min(startItem + itemsPerPage, items.length);
        for (let i = startItem; i < endItem; i++) {
            parent.appendChild(items[i]);
        }
        buttons.forEach((button) => {
            if (button !== buttons[page]) {
                button.classList.remove("active");
            } else {
                button.classList.add("active");
            }
        });
        const startButton = Math.max(0, page - Math.floor(maxButtons / 2));
        const endButton = Math.min(page + Math.floor(maxButtons / 2), buttons.length - 1);
        for (let i = 0; i < buttons.length; i++) {
            if (i >= startButton && i <= endButton) {
                buttons[i].style.display = "inline-block";
            } else {
                buttons[i].style.display = "none";
            }
        }
        currentPage = page;
    };
    const createButton = (text) => {
        return tag("li", {class: "page-item"}, [
            tag("button", {class: "page-link"}, [text]),
        ]);
    };
    const pages = Math.ceil(items.length / itemsPerPage);
    const paginationList = ((pages) => {
        const list = tag("ul", {class: "pagination"});
        const prev = createButton("<");
        prev.addEventListener("click", (event) => {
            event.preventDefault();
            if (currentPage > 0) {
                currentPage--;
                formatPage(currentPage);
            }
        });
        list.appendChild(prev);
        for (let i = 0; i < pages; i++) {
            const li = createButton(i + 1);
            li.addEventListener("click", (event) => {
                event.preventDefault();
                formatPage(i);
            });
            list.appendChild(li);
            buttons.push(li);
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
    })(pages);
    formatPage(0);
    paginationNav.innerHTML = "";
    paginationNav.appendChild(paginationList);
};