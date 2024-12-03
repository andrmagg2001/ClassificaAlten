document.addEventListener("DOMContentLoaded", function(event) {
  fetch('data/score.json')
  .then(response => response.json())
  .then(data => {
    leaderboardData = data;

    const tbody = document.querySelector('#leaderboard tbody');
    tbody.innerHTML = '';
  
    leaderboardData.sort((a, b) => {
      if (b.score !== a.score) {
        return b.score - a.score;
      }
  
      return a.losses - b.losses;
    });
  
    // Genera le righe della tabella
    leaderboardData.forEach((player, index) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
          <td>${index + 1}</td>
          <td>
            <img src="${player.foto}" alt="${player.name}" class="zoomable" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
          </td>
          <td>${player.name}</td>
          <td>${player.score}</td>
          <td>${player.wins}</td>
          <td>${player.losses}</td>
        `;
      tbody.appendChild(tr);
    });
  });

  document.getElementById('title').addEventListener('click', () => {
    window.open('rules.html', '_blank');
  });
});

