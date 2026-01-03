<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Beheerder Dashboard – JAS CAR WASH</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <img src="logo.jpeg" alt="JAS CAR WASH">
  JAS CAR WASH – Beheerder Dashboard
</header>

<div class="container">

  <!-- SYSTEEMINFO -->
  <div class="card">
    <h2>Systeeminformatie</h2>
    <div id="systeem"></div>
  </div>

  <!-- KLANTEN -->
  <div class="card">
    <h2>Klanten</h2>
    <div id="klanten"></div>
  </div>

  <!-- AFSPRAKEN -->
  <div class="card">
    <h2>Afspraken</h2>
    <div id="afspraken"></div>
  </div>

  <!-- TIJDVAK BESCHIKBAARHEID -->
  <div class="card">
    <h2>Tijdvak beschikbaarheid beheren</h2>

    <h3>Bestaande beschikbaarheid</h3>
    <div id="tijdvakBeschikbaarheid"></div>

    <h3>Datum toevoegen aan tijdvak</h3>
    <form id="addDateForm">
      <label>Tijdvak:</label>
      <select name="tijdvak_id" id="tijdvakSelect" required></select>

      <label>Datum:</label>
      <input type="date" name="datum" required>

      <button type="submit">Toevoegen</button>
    </form>
  </div>

</div>

<div class="footer">© 2026 JAS CAR WASH – Beheerderspaneel</div>

<script>
/* -------------------------
   DASHBOARD DATA LADEN
-------------------------- */

async function loadDashboard() {
  const response = await fetch("/api/beheerder-dashboard.php", {
    credentials: 'include'
  });
  const data = await response.json();

  if (data.error) {
    alert(data.error);
    window.location.href = "beheerder-login.html";
    return;
  }

  // Systeeminfo
  const sys = data.sysinfo;
  document.getElementById("systeem").innerHTML = `
    <p><strong>Uptime:</strong> ${sys.uptime}</p>
    <p><strong>CPU Load:</strong> ${sys.cpu}</p>
    <p><strong>Diskgebruik:</strong> ${sys.disk_used} MB van ${sys.disk_total} MB</p>
    <p><strong>Bezoeken (index):</strong> ${sys.visits}</p>
  `;

  // Klanten
  let klantenHTML = "";
  data.klanten.forEach(k => {
    klantenHTML += `
      <div class="card">
        <p><strong>${k.naam}</strong> – ${k.merk} ${k.model} (${k.nummerbord})</p>
        <p>Email: ${k.email ?? "—"} | Tel: ${k.telefoon ?? "—"}</p>
        <p>Laatste bezoek: ${k.laatste_bezoek ?? "—"}</p>
        <p>Volgende afspraak: ${k.volgende_afspraak ?? "—"}</p>
      </div>
    `;
  });
  document.getElementById("klanten").innerHTML = klantenHTML;

  // Afspraken
  let afsprakenHTML = "";
  data.afspraken.forEach(a => {
    afsprakenHTML += `
      <div class="card">
        <p><strong>${a.naam}</strong> – ${a.datum} – ${a.starttijd} tot ${a.eindtijd}</p>
      </div>
    `;
  });
  document.getElementById("afspraken").innerHTML = afsprakenHTML;
}

/* -------------------------
   TIJDVAK BESCHIKBAARHEID
-------------------------- */

async function loadTijdvakBeschikbaarheid() {
  const response = await fetch("/api/tijdvak-beschikbaarheid.php", {
    credentials: "include"
  });
  const data = await response.json();

  let html = "";
  data.forEach(row => {
    html += `
      <div class="card">
        <p><strong>${row.starttijd} - ${row.eindtijd}</strong></p>
        <p>Datum: ${row.datum}</p>
        <p>Status: ${row.beschikbaar == 1 ? "Beschikbaar" : "Geblokkeerd"}</p>
        <button onclick="toggleBeschikbaarheid(${row.id})">
          ${row.beschikbaar == 1 ? "Blokkeer" : "Activeer"}
        </button>
      </div>
    `;
  });

  document.getElementById("tijdvakBeschikbaarheid").innerHTML = html;
}

async function toggleBeschikbaarheid(id) {
  await fetch("/api/tijdvak-beschikbaarheid.php", {
    method: "POST",
    body: new URLSearchParams({ id }),
    credentials: "include"
  });
  loadTijdvakBeschikbaarheid();
}

/* -------------------------
   TIJDVAK SELECTIE LADEN
-------------------------- */

async function loadTijdvakkenForSelect() {
  const response = await fetch("/api/tijdvakken.php", {
    credentials: "include"
  });
  const data = await response.json();

  const select = document.getElementById("tijdvakSelect");
  data.forEach(t => {
    const opt = document.createElement("option");
    opt.value = t.id;
    opt.textContent = `${t.starttijd} - ${t.eindtijd}`;
    select.appendChild(opt);
  });
}

/* -------------------------
   DATUM TOEVOEGEN
-------------------------- */

document.getElementById("addDateForm").addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);

  const response = await fetch("/api/tijdvak-toevoegen-datum.php", {
    method: "POST",
    body: formData,
    credentials: "include"
  });

  const result = await response.text();
  if (result === "OK") {
    loadTijdvakBeschikbaarheid();
    e.target.reset();
  } else {
    alert(result);
  }
});

/* -------------------------
   INITIAL LOAD
-------------------------- */

loadDashboard();
loadTijdvakBeschikbaarheid();
loadTijdvakkenForSelect();

</script>

</body>
</html>
