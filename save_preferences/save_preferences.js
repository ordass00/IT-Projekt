var allRanges = document.querySelectorAll(".range-wrap");
allRanges.forEach(function (wrap) {
    var range = wrap.querySelector(".range");
    var bubble = wrap.querySelector(".bubble");
    range.addEventListener("input", function () {
        setBubble(range, bubble);
    });
    setBubble(range, bubble);
});
function setBubble(range, bubble) {
    var val = range.value;
    var min = range.min ? range.min : 0;
    var max = range.max ? range.max : 100;
    var newVal = Number(((val - min) * 100) / (max - min));
    bubble.innerHTML = val;
    document.getElementById("calories").value = val;
    bubble.style.left = "calc(" + newVal + "% + (" + (8 - newVal * 0.15) + "px))";
}
