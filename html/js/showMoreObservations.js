let dates = document.getElementsByClassName("dateObject");
let times = document.getElementsByClassName("timeObject");
let base_url = window.location;

//do this function when scrolled to the bottom of the page
$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
        // ajax call get data from server and append to the div
        getOtherObservations()
    }
});


function getOtherObservations() {
    let lastDate = dates[dates.length - 1].getAttribute("value");
    let lastTime = times[times.length - 1].getAttribute("value");
    fetch(base_url + "?extra=true&lastDate=" + lastDate + "&lastTime=" + lastTime)
        .then(resp => resp.text())
        .then(myHTML => document.getElementById("observationCardsContainer").insertAdjacentHTML("beforeend", myHTML))
        .catch(a => console.log(a));
}