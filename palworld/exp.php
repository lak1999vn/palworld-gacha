<?php
// Start the session
session_start();

// Set the session timeout duration (10 minutes in this example)
$timeout = 10 * 60; // 10 minutes in seconds

// Check if the user is logged in
if (!isset ($_SESSION['username'])) {
    // User is not logged in. Redirect them to the login page
    header('Location: login.html');
    exit;
} else if (isset ($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    // Last activity was more than $timeout seconds ago
    // Unset session variable and destroy session
    session_unset();
    session_destroy();

    // Redirect to the login page
    header('Location: login.html');
    exit;
} else {
    // User is logged in and session is not expired. Update last activity time
    $_SESSION['last_activity'] = time();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="middle.css">
    
    
    <style>
        @keyframes moveGradient {
            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 0, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 0, 0);
            }
        }

        @font-face {
            font-family: Cyber;
            src: url("https://assets.codepen.io/605876/Blender-Pro-Bold.otf");
            font-display: swap;
        }


        .cybr-btn {
            width: 400px;
            height: 130px;
            position: absolute;
            top: 0px;
            right: 5px;
            --primary: hsl(var(--primary-hue), 85%, calc(var(--primary-lightness, 50) * 1%));
            --shadow-primary: hsl(var(--shadow-primary-hue), 90%, 50%);
            --primary-hue: 0;
            --primary-lightness: 50;
            --color: hsl(0, 0%, 100%);

            --shadow-primary-hue: 180;
            --label-size: 9px;
            --shadow-secondary-hue: 60;
            --shadow-secondary: hsl(var(--shadow-secondary-hue), 90%, 60%);
            --clip: polygon(0 0, 100% 0, 100% 100%, 95% 100%, 95% 90%, 85% 90%, 85% 100%, 8% 100%, 0 70%);
            --border: 4px;
            font-family: 'Cyber', sans-serif;
            color: var(--color);
            background: transparent;
            text-transform: uppercase;
            font-size: var(--font-size);
            outline: transparent;
            letter-spacing: 2px;
            font-weight: 700;
            border: 0;
            line-height: 50px;
            text-align: left;
            padding-left: 100px;
        }

        .cybr-btn:after,
        .cybr-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            clip-path: var(--clip);
            z-index: -1;
        }

        .cybr-btn:before {
            background: var(--shadow-primary);
            transform: translate(var(--border), 0);
        }

        .cybr-btn:after {
            background: var(--primary);
        }

        body {
            background: rgb(25, 25, 33);
            overflow: hidden;
        }

        

        .inventory2 {
            position: absolute;
            right: 10px;
            bottom: 20px;
            margin: 50px auto;
            width: 370px;
            max-width: 370px;
            padding: 10px 15px 6px;
            height: 670px;
            border: 2px solid #1c3344;
            background: #0e1a23;
            border-color: yellow;
        }

        .inventory2>.item {
            float: none;
            cursor: pointer;
            margin: 4px 2px 0.5px 2px;
        }

        body {
            display: flex;
         
            align-items: center;
            flex-direction: column;
        }

        #myVideo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            object-fit: contain;
        }


        #container {
            position: relative;
            /* This will make the child elements position relative to this container */
        }

        #all-items {
            position: absolute;
            left: 250px;
            width: 120px;
            /* Adjust as needed */
            max-height: 100vh;
            overflow-y: auto;
            padding: 10px;
            border: 2px solid #1c3344;
            background: #0e1a23;
        }

        #triangle,
        #triangle2 {
            animation: pulse 2s infinite;
        }

        #triangle {
            position: absolute;
            /* This will position the triangle relative to the #container div */
            left: 400px;
            /* This will move the triangle to the left side of the #container div */
            width: 0;
            height: 0;
            border-top: 50vh solid transparent;
            border-bottom: 50vh solid transparent;
            border-left: 65px solid rgb(248, 4, 4);
        }

        #triangle2 {
            position: absolute;
            /* This will position the triangle relative to the #container div */
            left: 150px;
            /* Adjust this value to position the triangle */
            width: 0;
            height: 0;
            border-top: 50vh solid transparent;
            border-bottom: 50vh solid transparent;
            border-left: 95px solid rgb(255, 0, 0);
        }

        #all-items ul {
            list-style-type: none;
            padding: 0;
        }

        #all-items li {
            padding: 5px;
            border-bottom: 1px solid #ccc;
            color: #fff;
            /* Make the text white to contrast with the dark background */
        }

        .all-items-item {
            position: relative;
            width: 100px;
            /* Adjust as needed */
            height: 100px;
            /* Adjust as needed */
            background-size: cover;
            background-position: center;
            margin-bottom: 10px;
        }

        .all-items-item p {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black */
            color: #fff;
            margin: 0;
            padding: 5px;
            box-sizing: border-box;
            white-space: normal;
            /* Allow the text to wrap to the next line */
        }

        .tooltip {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
        }

        .all-items-item:hover .tooltip {
            visibility: visible;
        }

        .item:hover .tooltip {
            visibility: visible;
        }

        #certain-items-box {
            border: 2px solid #FF4500;
            /* Orange border */
            padding: 10px;
            /* Add some padding */
            display: flex;
            /* Display items in a row */
            flex-direction: column;
            /* Make items stack vertically */
            align-items: center;
            /* Center items horizontally */
            position: absolute;
            /* Position the box absolutely */
            left: 0;
            /* Position the box at the left edge of its containing element */
            background: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background */
            border-radius: 5px;
            /* Rounded corners */
            height: 95vh; /* Adjust as needed */
            overflow: auto;
        
        }

        #certain-items-box .item {
    width: 100px;
    height: 100px;
    margin: 10px;
    background-size: cover;
    background-position: center;
    position: relative;
    transition: transform 0.3s ease;  /* Add this line */
}

#certain-items-box .item:hover {
    cursor: pointer;
    transform: scale(1.1);  /* Add this line */
}

#certain-items-box .item .tooltip {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
    position: absolute;
    z-index: 1;
    font-family: 'Cyber', Times, serif;
}

        #certain-items-box .item:hover .tooltip {
            visibility: visible;
        }

        .user-info {
            position: absolute;
            top: 0;
            right: 0;
            width: 425px;
            /* Adjust as needed */
            height: 70px;
            /* Adjust as needed */
            background-color: #f0f0f0;
            /* Adjust as needed */
            padding: 30px;
            /* Adjust as needed */
        }

        body .user-info {
            width: 450px !important;
            /* your desired width */
            ;
        }

        #coins img {
            height: 1em;
            /* Adjust as needed */
            vertical-align: middle;
        }

        #username,
        #coins {
            font-size: 2em;
            /* Adjust as needed */
            font-family: 'Cyber', sans-serif;
        }

        #interchange {
            position: absolute;
            bottom: 250px;
            right: 415px;
            z-index: 9999;
            width: 50px;
            height: 50px;
        }

        #interchange img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cyberpunk-button {
            --primary: hsl(var(--primary-hue), 85%, calc(var(--primary-lightness, 50) * 1%));
            --shadow-primary: hsl(var(--shadow-primary-hue), 90%, 50%);
            --primary-hue: 0;
            --primary-lightness: 50;
            --color: hsl(0, 0%, 100%);

            --shadow-primary-hue: 180;
            --label-size: 9px;
            --shadow-secondary-hue: 60;
            --shadow-secondary: hsl(var(--shadow-secondary-hue), 90%, 60%);
            --clip: polygon(0 0, 100% 0, 100% 100%, 95% 100%, 95% 90%, 85% 90%, 85% 100%, 8% 100%, 0 70%);
            --border: 4px;
            --shimmy-distance: 5;
            --clip-one: polygon(0 2%, 100% 2%, 100% 95%, 95% 95%, 95% 90%, 85% 90%, 85% 95%, 8% 95%, 0 70%);
            --clip-two: polygon(0 78%, 100% 78%, 100% 100%, 95% 100%, 95% 90%, 85% 90%, 85% 100%, 8% 100%, 0 78%);
            --clip-three: polygon(0 44%, 100% 44%, 100% 54%, 95% 54%, 95% 54%, 85% 54%, 85% 54%, 8% 54%, 0 54%);
            --clip-four: polygon(0 0, 100% 0, 100% 0, 95% 0, 95% 0, 85% 0, 85% 0, 8% 0, 0 0);
            --clip-five: polygon(0 0, 100% 0, 100% 0, 95% 0, 95% 0, 85% 0, 85% 0, 8% 0, 0 0);
            --clip-six: polygon(0 40%, 100% 40%, 100% 85%, 95% 85%, 95% 85%, 85% 85%, 85% 85%, 8% 85%, 0 70%);
            --clip-seven: polygon(0 63%, 100% 63%, 100% 80%, 95% 80%, 95% 80%, 85% 80%, 85% 80%, 8% 80%, 0 70%);
            font-family: 'Cyber', sans-serif;
            color: var(--color);
            cursor: pointer;
            background: transparent;
            text-transform: uppercase;
            font-size: var(--font-size);
            outline: transparent;
            letter-spacing: 2px;
            position: relative;
            font-weight: 700;
            border: 0;
            min-width: 300px;
            height: 75px;
            line-height: 75px;
            position: fixed;
            z-index: 1000000;
            right: 50px;

        }

        .cyberpunk-button:hover {
            --primary: hsl(var(--primary-hue), 85%, calc(var(--primary-lightness, 50) * 0.8%));
        }

        .cyberpunk-button:active {
            --primary: hsl(var(--primary-hue), 85%, calc(var(--primary-lightness, 50) * 0.6%));
        }

        .cyberpunk-button:after,
        .cyberpunk-button:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            clip-path: var(--clip);
            z-index: -1;
        }

        .cyberpunk-button:before {
            background: var(--shadow-primary);
            transform: translate(var(--border), 0);
        }

        .cyberpunk-button:after {
            background: var(--primary);
        }

        .cyberpunk-button__tag {
            position: absolute;
            padding: 1px 4px;
            letter-spacing: 1px;
            line-height: 1;
            bottom: -5%;
            right: 5%;
            font-weight: normal;
            color: hsl(0, 0%, 0%);
            font-size: var(--label-size);
        }

        .cyberpunk-button__glitch {
            position: absolute;
            top: calc(var(--border) * -1);
            left: calc(var(--border) * -1);
            right: calc(var(--border) * -1);
            bottom: calc(var(--border) * -1);
            background: var(--shadow-primary);
            text-shadow: 2px 2px var(--shadow-primary), -2px -2px var(--shadow-secondary);
            clip-path: var(--clip);
            animation: glitch 2s infinite;
            display: none;
        }

        .cyberpunk-button:hover .cyberpunk-button__glitch {
            display: block;
        }

        .cyberpunk-button__glitch:before {
            content: '';
            position: absolute;
            top: calc(var(--border) * 1);
            right: calc(var(--border) * 1);
            bottom: calc(var(--border) * 1);
            left: calc(var(--border) * 1);
            clip-path: var(--clip);
            background: var(--primary);
            z-index: -1;
        }

        @keyframes glitch {
            0% {
                clip-path: var(--clip-one);
            }

            2%,
            8% {
                clip-path: var(--clip-two);
                transform: translate(calc(var(--shimmy-distance) * -1%), 0);
            }

            6% {
                clip-path: var(--clip-two);
                transform: translate(calc(var(--shimmy-distance) * 1%), 0);
            }

            9% {
                clip-path: var(--clip-two);
                transform: translate(0, 0);
            }

            10% {
                clip-path: var(--clip-three);
                transform: translate(calc(var(--shimmy-distance) * 1%), 0);
            }

            13% {
                clip-path: var(--clip-three);
                transform: translate(0, 0);
            }

            14%,
            21% {
                clip-path: var(--clip-four);
                transform: translate(calc(var(--shimmy-distance) * 1%), 0);
            }

            25% {
                clip-path: var(--clip-five);
                transform: translate(calc(var(--shimmy-distance) * 1%), 0);
            }

            30% {
                clip-path: var(--clip-five);
                transform: translate(calc(var(--shimmy-distance) * -1%), 0);
            }

            35%,
            45% {
                clip-path: var(--clip-six);
                transform: translate(calc(var(--shimmy-distance) * -1%));
            }

            40% {
                clip-path: var(--clip-six);
                transform: translate(calc(var(--shimmy-distance) * 1%));
            }

            50% {
                clip-path: var(--clip-six);
                transform: translate(0, 0);
            }

            55% {
                clip-path: var(--clip-seven);
                transform: translate(calc(var(--shimmy-distance) * 1%), 0);
            }

            60% {
                clip-path: var(--clip-seven);
                transform: translate(0, 0);
            }

            31%,
            61%,
            100% {
                clip-path: var(--clip-four);
            }
        }

        .cyberpunk-button:nth-of-type(2) {
            --primary-hue: 260;
        }

        .sell-button {
            position: fixed;
            right: 0;
            bottom: 0;
            width: 60px !important;
            /* Adjust this value as needed */
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .store-button {
            position: fixed;
            right: 0;
            top: 140px;
            width: 60px !important;
            /* Adjust this value as needed */
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        #myVideo {
            position: absolute;
            left: 10px;
        }

        
        .go-button {
            position: relative;
            font-size: 23px;
            left: 0px;
            /* Adjust this value as needed */
            top: 0px;
            width: 100px;
            /* Adjust this value as needed */
            /* Add any other styles you want for the "Go" button */
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <audio id="button-sound" src="open.mp3" preload="auto"></audio>

    <video autoplay muted loop id="myVideo">
        <source src="Pal.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>



<!-- LEFT AREA -->
<div class="left-container" style="display: flex; flex-direction: column; justify-content: space-between;">
    <div id="certain-items-box"></div>
    <div id="all-items">
        <h2></h2>
        <ul>
        </ul>
    </div>
    <div id="triangle"></div>
    <div id="triangle2"></div>
</div>
<!-- LEFT AREA -->




<!-- MIDDLE AREA -->
    <div class="middle-container" style="display: flex; flex-direction: column; align-items: center;">
    <div class="raffle-roller">
        <div class="raffle-roller-holder">
            <div class="raffle-roller-container" style="margin-left: 0px;">
            </div>
        </div>
    </div>
    <div
        style="background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 5px; width: 40%; margin: 0 auto; text-align: center;">
        <span style="font-size: 25px; font-family: 'Cyber', Courier, monospace; color: #FF4500; font-weight: bold;">Your
            reward is <span style="color: green;" id="rolled">rolling</span></span>
    </div>
            <button id="goButton" class="cyberpunk-button go-button">
                Quay<span aria-hidden>_10_AGI_Coins</span>
                <span aria-hidden class="cyberpunk-button__glitch">Quay_10_AGI_Coins</span>
                <span aria-hidden class="cyberpunk-button__tag">R25</span>
            </button>
            
            <div class="inventory"></div>
        
        <button id="Refresh" class="cyberpunk-button go-button">
                Refresh<span aria-hidden></span>
                <span aria-hidden class="cyberpunk-button__glitch">Refresh</span>
                <span aria-hidden class="cyberpunk-button__tag">R25</span>
            </button>
    </div>
    </div>
    
<!-- MIDDLE AREA -->





    </div>
    <div class="cybr-btn">
        <div id="username">
            <?php echo $_SESSION['username'] . " - " . $_SESSION['name']; ?>
        </div>
        <div id="coins">
            <img src="https://static.vecteezy.com/system/resources/previews/008/854/653/non_2x/coin-cryptocurrency-bitcoin-free-png.png"
                alt="Coin Icon"> AGI Coins:
            <span id="coin-value">
                <?php include 'fetch-coins.php'; ?>
            </span>
        </div>
        
    </div>



    <div class="inventory2"></div>

    <button class="cyberpunk-button sell-button" id="sellButton">
        Sell<span aria-hidden>_</span>
        <span aria-hidden class="cyberpunk-button__glitch">Sell_</span>
        <span aria-hidden class="cyberpunk-button__tag">R25</span>
    </button>

    <button class="cyberpunk-button store-button" id="receiveButton">
        Receive<span aria-hidden>_</span>
        <span aria-hidden class="cyberpunk-button__glitch">Receive_</span>
        <span aria-hidden class="cyberpunk-button__tag">R25</span>
    </button>

    

                    <script>
                       

// Define the randomInt function here                   
var audio = new Audio('open.mp3');

var insufficientBalance = false; // Add this line at the top of your script

document.getElementById('goButton').addEventListener('click', function () {
    // Make AJAX call to subtract coins
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "subtract-coins.php", true);
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Check if the response is "Insufficient Balance"
            if (this.responseText.trim() == "Insufficient Balance") {
                alert("Insufficient Balance");
                insufficientBalance = true; // Set the flag to true
            } else {
                // Update coins display
                document.getElementById('coin-value').innerHTML = this.responseText;
                insufficientBalance = false; // Set the flag to false

                // Play the sound and call the generate function
                audio.play();
                generate(1);
            }
        }
    };
    xhr.send();
});



audio.addEventListener('playing', function () {
    document.getElementById('goButton').disabled = true;
    document.getElementById('goButton').classList.add('disabled');
});
audio.addEventListener('ended', function () {
    document.getElementById('goButton').disabled = false;
    document.getElementById('goButton').classList.remove('disabled');
});
$(document).ready(function () {
                            var certainItems = {
                                warrior: {
                                    name: "Gói Chiến binh",
                                    img: "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3d/Crossed_swords.svg/512px-Crossed_swords.svg.png",
                                    price: "10",
                                    backgroundColor: "#F71C06" //red
                                },
                                miner: {
                                    name: "Gói Thợ mỏ",
                                    img: "https://purepng.com/public/uploads/large/purepng.com-fortnite-pickaxefortnitefortnite-battle-royalebattle-royaleepic-gamesgames-1251525435892uurvn.png",
                                    price: "9",
                                    backgroundColor: "#0644F7" 
                                },
                                farmer: {
                                    name: "Gói Nông dân",
                                    img: "https://cdn-icons-png.flaticon.com/512/6678/6678119.png",
                                    price: "3",
                                    backgroundColor: "#0DF706" 
                                },
                                slave: {
                                    name: "Gói Công nhân",
                                    img: "https://images.vexels.com/media/users/3/298567/isolated/preview/7d55cb620382f4528fdf0c9f66aced03-blacksmith-hammer-illustration.png",
                                    price: "8",
                                    backgroundColor: "#F7E806 " //yellow
                                },
                                cook: {
                                    name: "Gói Đầu bếp",
                                    img: "https://pngimg.com/d/chef_PNG22.png",
                                    price: "10",
                                    backgroundColor: "#EC70E1" //jade
                                },
                                exp: {
                                    name: "Gói Exp Player",
                                    img: "https://cdn-icons-png.flaticon.com/512/5569/5569383.png",
                                    price: "10",
                                    backgroundColor: "#128159" //jade
                                },
                                gold: {
                                    name: "Gói Vàng",
                                    img: "https://palworld.wiki.gg/images/4/49/Gold_Coin_icon.png",
                                    price: "5",
                                    backgroundColor: "#9406F7 " 
                                },
                                fruit: {
                                    name: "Gói Skill Pal",
                                    img: "https://palworld.wiki.gg/images/4/43/Neutral_Skill_Fruit_icon.png",
                                    price: "4",
                                    backgroundColor: "#F6F6F6 " //white
                                },
                                resource: {
                                    name: "Gói Nguyên liệu",
                                    img: "https://pngimg.com/d/silver_PNG17189.png",
                                    price: "4",
                                    backgroundColor: "#70EAEC " //white
                                },

                            };
                            for (var key in certainItems) {
    (function(key) {
        var item = certainItems[key];
        var itemDiv = $("<div class='item' style='background-image: url(" + item.img + "); background-color:" + item.backgroundColor + ";'><p class='tooltip'>" + item.name + "</p></div>");
        itemDiv.appendTo('#certain-items-box');

        // Add a click event listener to the div
        itemDiv.click(function() {
            window.location.href = key + '.php';
        });
    })(key);
}

                        });

                        
                       
                        $('#goButton').on('click', function() {
        // Start the roller
        startRoller();

        audio.addEventListener('timeupdate', function () {
            // If the audio is within the last 0.5 seconds
            if (this.duration - this.currentTime < 0.7) {
                // Call the updateInventory function
                updateInventory();

                // Remove the event listener to prevent multiple calls
                this.removeEventListener('timeupdate', arguments.callee);
            }
        });
    });
                        $('#Refresh').on('click', function() {
    updateInventory();
});
function updateInventory() {
    $.ajax({
        url: 'inventory.php',
        type: 'GET',
        success: function(response) {
            // Clear the inventory
            $('.inventory').empty();

            console.log(response); // Log the response
            var itemSkins = JSON.parse(response);

            // Array of JSON file names
            var jsonFileNames = ['warrior.json', 'miner.json','farmer.json','slave.json','cook.json','exp.json']; // Add more file names as needed

            // Fetch all the JSON files
            Promise.all(jsonFileNames.map(fileName => fetch(fileName).then(response => response.json())))
                .then(files => {
                    // files is an array of the parsed JSON files

                    // Loop through each item skin
                    itemSkins.forEach(function(itemSkin) {
                        console.log(itemSkin); // Log the item skin

                        // Loop through each file
                        files.forEach(function(file) {
                            // Loop through each rarity in the file
                            for (var rarity in file) {
                                // Find the item with the matching skin
                                var item = file[rarity].find(function(item) {
                                    return item.skin === itemSkin;
                                });

                                // If the item was found
                                if (item) {
                                    // Create a new div for the item
                                    var itemDiv = document.createElement('div');
                                    itemDiv.className = 'item';
                                    itemDiv.style.backgroundImage = 'url(' + item.img + ')';
                                    itemDiv.style.backgroundColor = item.backgroundColor;
                                    itemDiv.title = item.skin; // Set the title attribute to the skin property of the item

                                    // Append the item div to the inventory
                                    $('.inventory').append(itemDiv);

                                    // Stop searching
                                    break;
                                }
                            }
                        });
                    });
                });
        }
    });
}



                        
                        function startRoller() {
    // Reset the margin-left property immediately
    $('.raffle-roller-container').css("margin-left", "0px");

    // Delay the reset of the transition property to allow the margin-left reset to happen instantly
    setTimeout(function() {
        $('.raffle-roller-container').css("transition", "none");
    }, 0);

    var promises = [];

    for (var i = 0; i < 101; i++) {
        var promise = $.ajax({
    url: 'decide.php',
    type: 'GET',
    data: { index: i },
    dataType: 'json' // Add this line
});

        promises.push(promise);
    }

    Promise.all(promises).then(function(items) {
        var generatedItems = items.map(function(item, i) {
    var element = '<div id="CardNumber' + i + '" class="item class_red_item" style="background-image:url(' + item.img + '); background-color:' + item.backgroundColor + ';" title="' + item.skin + '" data-rarity="' + item.rarity + '"></div>';
    $(element).appendTo('.raffle-roller-container');
    return item;
});

    setTimeout(function () {
        $('.raffle-roller-container').css({
            transition: "margin-left 8s cubic-bezier(.08,.6,0,1)",
            "margin-left": "-7400px" // Adjust this value as needed
        });

        setTimeout(function () {
            $('#CardNumber89').addClass('winning-item');
            $('#rolled').html(generatedItems[83].skin);
            var win_element = "<div class='item class_red_item' style='background-image: url(" + generatedItems[83].img + "); background-color:" + generatedItems[83].backgroundColor + ";'><p class='tooltip'>" + generatedItems[83].skin + "</p></div>"; // Added tooltip here
            

            // Call resetItems after the animation has finished
            setTimeout(function() {
                resetItems();
                $('.raffle-roller-container').css({
                    transition: "none",
                    "margin-left": "0px"
                });
            }, 100); // 8000ms for the animation duration + 100ms additional delay
        }, 8000); // This should be the same as the duration of the animation
    }, 500);
});
    function goRoll(skin, img, item) {
    // Display the reward
    $('#reward').html('<div class="item" style="background-image:url(' + img + ');" title="' + skin + '"></div>');
    
}
}

    function resetItems() {
    // Remove all items from the roller
    $('.raffle-roller-container').empty();

    // Reset the margin-left property of the roller
    $('.raffle-roller-container').css({
        'margin-left': '0px',
        'transition': 'none'
    });
}

// Add a click event listener to the items in the main inventory
$('body').on('click', '.inventory .item', function () {
    // Clone the clicked item
    var clonedItem = $(this).clone();

    // Set the title attribute on the cloned item
    clonedItem.attr('title', $(this).attr('title'));

    // Log the title attribute of the cloned item
    console.log(clonedItem.attr('title'));

    // Append the cloned item to inventory2
    $('.inventory2').append(clonedItem);

    // Remove the original item from the main inventory
    $(this).remove();
});

// Add a click event listener to the items in inventory2
$('body').on('click', '.inventory2 .item', function () {
    // Clone the clicked item
    var clonedItem = $(this).clone();

    // Set the title attribute on the cloned item
    clonedItem.attr('title', $(this).attr('title'));

    // Log the title attribute of the cloned item
    console.log(clonedItem.attr('title'));

    // Append the cloned item to the main inventory
    $('.inventory').append(clonedItem);

    // Remove the original item from inventory2
    $(this).remove();
});
                    
$(document).ready(function () {
    var allItemsBox = document.getElementById('all-items');

    // Fetch the warrior.json file
    fetch('exp.json')
        .then(response => response.json())
        .then(file => {
            // file is the parsed JSON file

            // Loop through each rarity in the file
            for (var rarity in file) {
                file[rarity].forEach(function (item) {
                    var itemDiv = document.createElement('div');
                    itemDiv.className = 'all-items-item';
                    itemDiv.style.backgroundImage = 'url(' + item.img + ')';
                    itemDiv.style.backgroundColor = item.backgroundColor;

                    var skinName = document.createElement('p');
                    skinName.textContent = item.skin;
                    skinName.className = 'tooltip'; // Add a class to style the tooltip
                    itemDiv.appendChild(skinName);

                    allItemsBox.appendChild(itemDiv);
                });
            }
        });
});

                        $(document).ready(function () {
                            $('.cyberpunk-button').on('mousedown', function () {
                                $(this).addClass('active');
                            });

                            $('.cyberpunk-button').on('mouseup', function () {
                                $(this).removeClass('active');
                            });
                        });

                        // Reset the timeout whenever there's activity
                        var timeout;

                        function resetTimeout() {
                            // Clear the previous timeout
                            clearTimeout(timeout);

                            // Set the timeout again
                            timeout = setTimeout(function () {
                                window.location.href = "index.php";
                            }, 600000); // 600000 milliseconds = 10 minutes
                        }

                        // Reset the timeout whenever there's a click, keydown, or mousemove event
                        window.addEventListener('click', resetTimeout);
                        window.addEventListener('keydown', resetTimeout);
                        window.addEventListener('mousemove', resetTimeout);

                        // Set the initial timeout
                        resetTimeout();
                        $(document).ready(function() {
                            $('#sellButton').click(function() {
    // Log the title attribute of each item in inventory2
$('.inventory2 > .item').each(function() {
    console.log($(this).attr('title'));
});

// Get the information of the items in the inventory2
var items = [];
$('.inventory2 > .item').each(function() {
    var item = {
        skin: $(this).attr('title'), // Access the title attribute
    };
    items.push(item);
});

// Make a copy of the items array
var itemsCopy = items.slice();

// Send the original array to "sell.php"
$.ajax({
    url: 'sell.php',
    type: 'POST',
    data: {items: JSON.stringify(items)}, // Convert the items array to a JSON string
    success: function(response) {
        // Handle the response from the server
        console.log(response);

        // Send the copy of the array to "add.php"
        $.ajax({
            url: 'add.php',
            type: 'POST',
            data: {items: JSON.stringify(itemsCopy)}, // Convert the copy of the items array to a JSON string
            success: function(response) {
                // Handle the response from the server
                console.log(response);

                // Fetch the updated agi coins value from the server
                $.ajax({
                    url: 'updatecoin.php',
                    type: 'GET',
                    success: function(response) {
                        // Update the displayed agi coins value
                        var coinValueElement = document.getElementById('coin-value');
                        coinValueElement.innerHTML = response;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle any errors
                        console.log(textStatus, errorThrown);
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any errors
                console.log(textStatus, errorThrown);
            }
        });
    },
    error: function(jqXHR, textStatus, errorThrown) {
        // Handle any errors
        console.log(textStatus, errorThrown);
    }
});

// Clear the inventory2
$('.inventory2').empty();

// Play sell.mp3
var audio = new Audio('sell.mp3');
audio.play();
});
    });



    $(document).ready(function() {
    $('#receiveButton').click(function() {
        // Log the title attribute of each item in inventory2
        $('.inventory2 > .item').each(function() {
            console.log($(this).attr('title'));
        });

        // Get the information of the items in the inventory2
        var items = [];
        $('.inventory2 > .item').each(function() {
            var item = {
                skin: $(this).attr('title'), // Access the title attribute
            };
            items.push(item);
        });

        // Send the original array to "sell.php"
        $.ajax({
            url: 'receive.php',
            type: 'POST',
            data: {items: JSON.stringify(items)}, // Convert the items array to a JSON string
            success: function(response) {
                // Handle the response from the server
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any errors
                console.log(textStatus, errorThrown);
            }
        });

        // Clear the inventory2
        $('.inventory2').empty();

        // Play sell.mp3
        var audio = new Audio('sell.mp3');
        audio.play();
    });
});
                    </script>
</body>

</html>