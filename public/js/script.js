const makeReviewStars = (stars) => {
    const updateStars = (i) => {
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

document.querySelectorAll("[data-reviewstars]").forEach((stars) => {
    makeReviewStars(stars);
});

document.querySelectorAll("[data-available]").forEach((element) => {
    setAvailableParagraph(element, +element.dataset.available);
});

document.querySelectorAll("[data-shipping]").forEach((element) => {
    setShippingParagraph(element, +element.dataset.shipping);
});