import "./bootstrap";

window.getCourtsDatabyName = async function (searchText) {
    const res = await fetch(
        `/courts/search?name=${encodeURIComponent(searchText)}`,
        {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        }
    );
    const data = await res.json();
    return data;
};
