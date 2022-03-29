let nextId = 0;
let markedArr = [];

$(document).ready(() => {
    $("#add").on("click", addItem);
    $("#sort").on("click", sortItem);
    $("#remove").on("click", removeItem);
    $("#toggle").on("click", toggeList);

});

function markElement(id) {
    if (markedArr.includes(id)) {
        markedArr.splice(markedArr.indexOf(id), 1);
        $("#" + id).removeClass("marked").addClass("unmarked")
    } else {
        markedArr.push(id);
        $("#" + id).addClass("marked")
    }
}


function addItem() {
    e = $("#item").val();
    const checkbox = `<input type="checkbox" onclick="markElement('item-${nextId}')">`;
    const sortUp = `<input type="button" value="&#8593;" onclick="moveUp('item-${nextId}')">`;
    const sortDown = `<input type="button" value="&#8595;" onclick="moveDown('item-${nextId}')">`;
    //const sortDown;
    $("ol").append(`<li id="item-${nextId}">` + checkbox + sortUp + sortDown + e + "</li>");
    $("#item-" + nextId).hide().fadeIn(500);
    $("#item").val("");
    console.log("element added");
    nextId++;
}


function toggeList() {
    let list = $("ol").fadeToggle(500);
}

function moveUp(id) {

    let list = $("ol").children("li");
    const item = $("#" + id);
    const index = list.index(item)
    if (index == 0) {
        return;
    }
    const previousElement = list.eq(index - 1);
    (item).insertBefore(previousElement);

}
function moveDown(id) {

    let list = $("ol").children("li");
    const item = $("#" + id);
    const index = list.index(item)
    if (index == list.length) {
        return;
    }
    const nextElement = list.eq(index + 1);
    (item).insertAfter(nextElement);

}

function removeItem() {
    markedArr.forEach(element => {
        $('#' + element).remove();
    });
    markedArr = [];
}



function sortItem() {
    $("ol").each(log_them)
}

