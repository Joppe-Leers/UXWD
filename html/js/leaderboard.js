let weekly = document.getElementById("weekly");
let monthly = document.getElementById("monthly");
let overall = document.getElementById("overall");

weekly.addEventListener("click", weeklyClicked);
monthly.addEventListener("click", monthlyClicked);
overall.addEventListener("click",overallClicked);

let filter = document.querySelector('input[id="hidden_variable_filter"]').value;
let baseUrl = document.querySelector('input[id="hidden_base_url"]').value;

function weeklyClicked() {
    weekly.classList.add("active");
    monthly.classList.remove("active");
    overall.classList.remove("active");
    let url = getLeaderboardURL("weeklyPoints");
    fetchLeaderboardData(url);
}

function monthlyClicked() {
    weekly.classList.remove("active");
    monthly.classList.add("active");
    overall.classList.remove("active");
    let url = getLeaderboardURL("monthlyPoints");
    fetchLeaderboardData(url);
}

function overallClicked() {
    weekly.classList.remove("active");
    monthly.classList.remove("active");
    overall.classList.add("active");
    let url = getLeaderboardURL("points");
    fetchLeaderboardData(url);
}

function fetchLeaderboardData(url) {
    fetch(url)
        .then(resp => resp.text())
        .then(data => document.getElementById("leaderboard_container").innerHTML = data)
        .catch(a => console.log(a));
}

function getLeaderboardURL(period) {
    switch(filter) {
        case "friends":
            return baseUrl + '/fetchFriendsLeaderboard/' + period;
        case "worldwide":
            return baseUrl + '/fetchWorldwideLeaderboard/' + period;
        default:
            return baseUrl + '/fetchGroupLeaderboard/' + filter +'/' + period;
    }
}
