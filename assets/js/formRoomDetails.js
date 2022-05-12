const ul = document.querySelector("#formRoom");
const template = document.querySelector("#form-template");
const addButton = document.querySelector(".addBed");
const saveButton = document.querySelector(".save");
const removeButtons = document.querySelectorAll(".removeBed");


function onClickRemove(){
    this.parentNode.remove();
}
// for (const removeButton of removeButtons) {
//     removeButton.addEventListener("click",onClickRemove)
// }


function addFormToCollection() {
    const item = document.createElement('li');
    item.innerHTML = template.innerHTML
        .replace(
            /__name__/g,
            ul.dataset.index
        );
    ul.appendChild(item);
    //item.querySelector("button").addEventListener("click",onClickRemove);
    ul.dataset.index++;
};
addButton.addEventListener("click", addFormToCollection)


saveButton.addEventListener("click", function () {
    template.remove();
})