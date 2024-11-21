// Carica i dati da un file JSON
fetch('JSON/players.json')
  .then(response => response.json())
  .then(data => {
    leaderboardData = data;
    renderLeaderboard();
  });

// Funzione per aggiornare la leaderboard
function renderLeaderboard() {
  const tbody = document.querySelector('#leaderboard tbody');
  tbody.innerHTML = '';

  // Ordina la leaderboard in base al punteggio in ordine decrescente
  leaderboardData.sort((a, b) => b.score - a.score);

  // Genera le righe della tabella
  leaderboardData.forEach((player, index) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${index + 1}</td>
      <td><img src="${player.foto}" alt="${player.name}" class="player-photo"></td>
      <td>${player.name}</td>
      <td>${player.score}</td>
      <td>${player.wins}</td>
      <td>${player.losses}</td>
    `;
    tbody.appendChild(tr);
  });
}

// Render iniziale
renderLeaderboard();