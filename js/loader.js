var initialData = [
    { "name": "Stefano",      "wins": 8, "losses": 4, "foto": "images/players/Stefano.png",  "score": 6.75 },
    { "name": "Giuliano",     "wins": 8, "losses": 5, "foto": "images/players/Giuliano.png", "score": 6    },
    { "name": "Luis",         "wins": 8, "losses": 4, "foto": "images/players/lvi.png",      "score": 6    },
    { "name": "Andrea",       "wins": 8, "losses": 6, "foto": "images/players/Andrea.png",   "score": 5.25 },
    { "name": "Valerio L",    "wins": 5, "losses": 5, "foto": "images/players/ValerioL.png", "score": 4.75 },
    { "name": "Luca",         "wins": 4, "losses": 5, "foto": "images/players/Luca.png",     "score": 3    },
    { "name": "Matteo DP",    "wins": 2, "losses": 8, "foto": "images/players/MatteoDP.png", "score": 2    },
    { "name": "Matteo M",     "wins": 2, "losses": 7, "foto": "images/players/MM.png",       "score": 2    },
    { "name": "Daniele A",    "wins": 0, "losses": 2, "foto": "images/players/DanieleA.png", "score": 0    },
    { "name": "Federico",     "wins": 0, "losses": 0, "foto": "images/players/Federico.png", "score": 0    },
    { "name": "Pier Giorgio", "wins": 0, "losses": 0, "foto": "images/players/pgd.jpg",      "score": 0    },
    { "name": "Gianmarco",    "wins": 0, "losses": 0, "foto": "images/players/Zizzo.png",    "score": 0    },
    { "name": "Silvia",       "wins": 0, "losses": 0, "foto": "images/players/Silvia.png",   "score": 0    },
    { "name": "Valerio B",    "wins": 0, "losses": 1, "foto": "images/players/ValerioB.png", "score": 0    }
  ];

  // Salva i dati iniziali nel localStorage se non esistono
  if (!localStorage.getItem('leaderboardData')) 
  {
    localStorage.setItem('leaderboardData', JSON.stringify(initialData));
  }

  // Carica la leaderboard dal localStorage
  function loadLeaderboard() 
  {
    const leaderboardData = JSON.parse(localStorage.getItem('leaderboardData'));
    const tbody = document.querySelector('#leaderboard tbody');
    tbody.innerHTML = '';

    // Ordina la leaderboard in base al punteggio (decrescente)
    leaderboardData.sort((a, b) => {
      // Prima confronta i punti (in ordine decrescente)
      if (b.score !== a.score) {
        return b.score - a.score;
      }

      // Se i punti sono uguali, confronta le sconfitte (in ordine crescente)
      return a.losses - b.losses;
    });


    // Genera le righe della tabella
    leaderboardData.forEach((player, index) => 
    {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${index + 1}</td>
        <td call="table-cell">
          <img src="${player.foto}" alt="${player.name}" class="zoomable" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
        </td>
        <td>${player.name}</td>
        <td>${player.score}</td>
        <td>${player.wins}</td>
        <td>${player.losses}</td>
      `;
      tbody.appendChild(tr);
    });
  }

  /*
  // Funzione per aggiornare il punteggio
  function updateScore(pname, points, win, lose) 
  {
    const leaderboardData = JSON.parse(localStorage.getItem('leaderboardData'));
    const index = leaderboardData.findIndex(p => p.name === pname);

    var multiplier = 1;

    if (index !== -1) {
      // Applica il moltiplicatore in base alla posizione
      if (index < 6) {
        multiplier = 0.75;
      } else if (index >= 11) {
        multiplier = 1.25;
      }

      // Aggiungi i punti al punteggio
      leaderboardData[index].score  += parseFloat(points * multiplier);
      leaderboardData[index].wins   += parseInt(win);
      leaderboardData[index].losses += parseInt(lose);

      // Ordina i dati dopo aver aggiornato il punteggio
      leaderboardData.sort((a, b) => b.score - a.score);

      // Salva i dati aggiornati nel localStorage
      localStorage.setItem('leaderboardData', JSON.stringify(leaderboardData));

      alert(`Score updated for ${pname}!`);

      // Ricarica la leaderboard
      loadLeaderboard();
    } else {
      alert('Player Not Found!');
    }
  }

  // Gestione dell'evento per il pulsante di submit
  document.getElementById('submitBtn').addEventListener('click', () => {
    const pname  = document.getElementById('pname').value;
    const points = document.getElementById('points').value;
    const win    = document.getElementById('win').value;
    const lose   = document.getElementById('lose').value;

    const inputText = document.getElementById('pw').value;
    
    const encoder = new TextEncoder();
    const data    = encoder.encode(inputText);

    crypto.subtle.digest('SHA-256', data).then(function(hashBuffer) 
    {
      const hashArray = Array.from(new Uint8Array(hashBuffer)); // Array di byte
      const hashHex   = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join(''); // Stringa esadecimale
      
      if (hashHex === "c6f6c6df742f719738168244e020faed4a4a49b68defa68652c830a024ba7a08")
      {
        if (pname && points && win && lose) {
          updateScore(pname, points, win, lose);
        } else {
          alert('Form Error!');
        }
      }
      else
      {
        alert("Password Error!");
      }
    }).catch(function(err) {
      console.error(err);
    });

  });

  document.getElementById('resetBtn').addEventListener('click', () => {
    localStorage.setItem('leaderboardData', JSON.stringify(initialData));
    loadLeaderboard();
  });
  */

  document.getElementById('title').addEventListener('click', () => {
    window.open('rules.html', '_blank');
  });

  // Carica la leaderboard iniziale
  