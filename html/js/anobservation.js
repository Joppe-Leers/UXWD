let map;

// Initialize and add the map
function initMap() {
    let locationString = document.getElementById("observation_location").innerText;
    let locationArray = locationString.replace(/\s+/g, '').split(',');
    // The location of Uluru
    const uluru = { lat: parseFloat(locationArray[0]), lng: parseFloat(locationArray[1]) };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 14,
        center: uluru,
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
        position: uluru,
        map: map,
    });
}

document.getElementById("like_button").addEventListener("click", likeClicked);
document.getElementById("comment_button").addEventListener("click", commentClicked);

// this is far from
function likeClicked() {

    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    let url = base_url + "/fetchObservationLikeHTML/" + document.querySelector('input[id="hidden_variable_filter"]').value;
    setLikesOrComments(url);
}

function commentClicked() {

    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    let url =  base_url + "/fetchObservationCommentHTML/" + document.querySelector('input[id="hidden_variable_filter"]').value;
    setLikesOrComments(url);
}

function setLikesOrComments(url) {
    fetch(url)
        .then(resp => resp.text())
        .then(data => document.getElementById("likes_or_comment_placeholder").innerHTML = data)
        .catch(a => console.log(a));

}