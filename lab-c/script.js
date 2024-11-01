let map;

// Funkcja inicjalizująca mapę
function loadMap(lat = 40.665459, long = -73.965091) {
    map = L.map('map').setView([lat, long], 2);
    L.tileLayer.provider('Esri.WorldImagery').addTo(map);
}

// Funkcja pobierająca lokalizację użytkownika
function getMyLocation() {
    if (!navigator.geolocation) {
        alert("I need your location permission to continue.");
        return;
    }

    navigator.geolocation.getCurrentPosition((position) => {
        const lat = position.coords.latitude;
        const long = position.coords.longitude;
        map.setView([lat, long]);
        let marker = L.marker([lat, long]).addTo(map);
        marker.bindPopup("You are here!");
    }, (positionError) => {
        console.error(positionError);
    });
}

// Funkcja inicjalizująca powiadomienia
function requestNotificationPermission() {
    if (Notification.permission !== "granted" && Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                console.log("Zgoda na powiadomienia została udzielona.");
            } else {
                console.log("Powiadomienia zostały odrzucone.");
            }
        });
    }
}

// Funkcja zapisująca mapę jako obraz i dzieląca na puzzle
function saveMap() {
    leafletImage(map, function (err, canvas) {
        let mapImage = document.getElementById("savedImage");
        let imageContext = mapImage.getContext("2d");

        mapImage.width = 600;
        mapImage.height = 300;
        imageContext.drawImage(canvas, 0, 0, 600, 300);
        
        const puzzles = getPuzzles();
        drawPuzzles(puzzles);
        drawBoard();
    });
}

// Funkcja tworząca puzzle z obrazu mapy
function getPuzzles() {
    let image = document.getElementById("savedImage");
    const puzzles = [];
    const puzzleWidth = image.width / 4;
    const puzzleHeight = image.height / 4;

    for (let x = 0; x < 4; x++) {
        for (let y = 0; y < 4; y++) {
            const puzzle = document.createElement("canvas");
            puzzle.width = puzzleWidth;
            puzzle.height = puzzleHeight;
            const puzzleContext = puzzle.getContext("2d");

            puzzleContext.drawImage(
                image,
                x * puzzleWidth,
                y * puzzleHeight,
                puzzleWidth,
                puzzleHeight,
                0,
                0,
                puzzleWidth,
                puzzleHeight
            );
            
            const newId = y * 4 + x;
            puzzle.id = `puzzle-${newId}`;
            puzzles.push(puzzle);
        }
    }
    return shuffleArray(puzzles);
}

// Funkcja losująca puzzle
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Funkcja rysująca puzzle na ekranie
function drawPuzzles(puzzles) {
    const container = document.getElementById("puzzleContainer");
    container.innerHTML = '';

    puzzles.forEach((puzzle) => {
        const newCanvas = document.createElement("canvas");
        newCanvas.width = puzzle.width;
        newCanvas.height = puzzle.height;
        newCanvas.className = "puzzle";
        newCanvas.id = puzzle.id;

        newCanvas.setAttribute("draggable", "true");
        newCanvas.setAttribute("ondragstart", "dragPuzzle(event)");

        newCanvas.getContext("2d").drawImage(puzzle, 0, 0, puzzle.width, puzzle.height);
        container.appendChild(newCanvas);
    });
}

// Funkcja rysująca planszę
function drawBoard() {
    const boardContainer = document.getElementById("boardContainer");
    boardContainer.innerHTML = '';

    for (let i = 0; i < 16; i++) {
        const cell = document.createElement("div");
        cell.className = "board-cell";
        cell.id = `board-cell-${i}`;

        cell.setAttribute("ondrop", "dropPuzzle(event)");
        cell.setAttribute("ondragover", "allowDrop(event)");

        boardContainer.appendChild(cell);
    }
}

// Funkcje obsługi Drag and Drop
function allowDrop(event) {
    event.preventDefault();
}

function dragPuzzle(event) {
    event.dataTransfer.setData("text", event.target.id);
}

// Funkcja obsługująca upuszczanie puzzli
function dropPuzzle(event) {
    event.preventDefault();
    const puzzleId = event.dataTransfer.getData("text");
    const puzzlePiece = document.getElementById(puzzleId);
    if (puzzlePiece) {
        event.target.appendChild(puzzlePiece);
    }
    checkPuzzleCompletion();
}

// Funkcja sprawdzająca, czy wszystkie puzzle są na swoich miejscach
function checkPuzzleCompletion() {
    for (let index = 0; index < 16; index++) {
        const cell = document.getElementById(`board-cell-${index}`);
        const puzzlePiece = cell.firstChild;

        if (puzzlePiece) {
            const puzzleNumber = parseInt(puzzlePiece.id.split("-")[1], 10);
            if (puzzleNumber !== index) {
                console.log(`Puzzle ${puzzlePiece.id} jest na złym miejscu. Oczekiwano pozycji ${index}.`);
                return;
            }
        } else {
            console.log(`Komórka ${index} jest pusta.`);
            return;
        }
    }
    displayCongratulationsMessage();
}

function displayCongratulationsMessage() {
    const messageElement = document.getElementById("congratulationsMessage");
    messageElement.textContent = "Congratulations!";
    messageElement.style.display = "block";
    console.log("Układanka została poprawnie ułożona!");

    // Sprawdzamy, czy zgoda na powiadomienia jest udzielona
    if (!("Notification" in window)) {
        alert("Przeglądarka nie obsługuje powiadomień");
    }
    else if (Notification.permission === "granted") {
        new Notification("Congratulations! You completed the puzzle.");
        console.log("Powiadomienie zostało wyświetlone.");
    } else {
        console.log("Zgoda na powiadomienia nie została udzielona.");
    }
}


// Event listeners
document.getElementById("getImage").addEventListener("click", saveMap);
document.getElementById("getLocation").addEventListener("click", getMyLocation);

// Inicjalizacja mapy i zapytanie o powiadomienia
loadMap();
requestNotificationPermission();
