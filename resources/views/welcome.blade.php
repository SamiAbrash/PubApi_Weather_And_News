<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather and News</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        .weather, .news {
            margin-bottom: 20px;
        }
        .news-article {
            margin-bottom: 10px;
        }
        .news-article h3 {
            margin: 0;
            font-size: 1.2em;
        }
        .news-article p {
            margin: 5px 0;
        }
        #city-form {
            margin-bottom: 20px;
        }
        #city-form input {
            padding: 10px;
            font-size: 1em;
            margin-right: 10px;
        }
        #city-form button {
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
        }
    </style>
    <script>
        async function fetchWeatherAndNews(city) {
            try {
                const response = await fetch(`/api/weather-news?city=${city}`);
                const data = await response.json();

                if (response.ok) {
                    const weather = data.weather;
                    const news = data.news;

                    if (!weather || !weather.name || !weather.main || !weather.weather || !weather.weather[0]) {
                        throw new Error('Incomplete weather data received');
                    }

                    document.getElementById('weather').innerHTML = `
                        <h2>Weather in ${weather.name}</h2>
                        <p>Temperature: ${weather.main.temp} °C</p>
                        <p>Weather: ${weather.weather[0].description}</p>
                    `;

                    const newsHtml = news.articles.map(article => `
                        <div class="news-article">
                            <h3>${article.title}</h3>
                            <p>${article.description}</p>
                            <a href="${article.url}" target="_blank">Read more</a>
                        </div>
                    `).join('');
                    document.getElementById('news').innerHTML = `
                        <h2>Related News</h2>
                        ${newsHtml}
                    `;
                } else {
                    throw new Error(data.error || 'Error fetching data');
                }
            } catch (error) {
                document.getElementById('weather').innerHTML = `<p>${error.message}</p>`;
                document.getElementById('news').innerHTML = '';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('city-form').addEventListener('submit', event => {
                event.preventDefault();
                const city = event.target.city.value;
                fetchWeatherAndNews(city);
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <form id="city-form">
            <input type="text" name="city" placeholder="Enter city" required>
            <button type="submit">Get Weather and News</button>
        </form>
        <div id="weather" class="weather"></div>
        <div id="news" class="news"></div>
    </div>
</body>
</html>
