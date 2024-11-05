document.getElementById('checkButton').addEventListener('click', function() {
    const city = document.getElementById('city-input').value;
    if (city) {
        getCurrentWeather(city);
        getWeatherForecast(city);
    } else {
        alert('Proszę wpisać nazwę miasta.');
    }
});

function getCurrentWeather(city) {
    const apiKey = '04ad4a55e039618d42a358b7e2baea0d';
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=pl`;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const weatherInfo = `
                <h3>Bieżąca pogoda w ${data.name}</h3>
                <p>Temperatura: ${data.main.temp}°C</p>
                <p>Wilgotność: ${data.main.humidity}%</p>
                <p>Opis: ${data.weather[0].description}</p>
                <p></p>
            `;
            document.getElementById('weather-info').innerHTML = weatherInfo;
        } else {
            document.getElementById('weather-info').innerHTML = 'Nie udało się pobrać danych. Sprawdź nazwę miasta.';
        }
    };
    xhr.onerror = function() {
        document.getElementById('weather-info').innerHTML = 'Błąd połączenia. Spróbuj ponownie.';
    };
    xhr.send();
}




function getWeatherForecast(city) {
    const apiKey = '04ad4a55e039618d42a358b7e2baea0d';
    const url = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric&lang=pl`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const forecastInfo = data.list.slice(0, 5).map(forecast => {
                const date = new Date(forecast.dt * 1000);
                const day = date.toLocaleDateString();
                return `
                    <div>
                        <h4>${day}</h4>
                        <p>Temperatura: ${forecast.main.temp}°C</p>
                        <p>Opis: ${forecast.weather[0].description}</p>
                        <p></p>
                    </div>
                `;
            }).join('');
            document.getElementById('forecast-info').innerHTML = `
                <h3>Prognoza na 5 dni</h3>
                ${forecastInfo}
            `;
        })
        .catch(error => {
            document.getElementById('forecast-info').innerHTML = 'Błąd pobierania prognozy. Spróbuj ponownie.';
        });
}
