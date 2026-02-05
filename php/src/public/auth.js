async function register() {
    const res = await fetch('/api/register', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            username: document.getElementById('r-username').value,
            email: document.getElementById('r-email').value,
            display_name: document.getElementById('r-display').value,
            password: document.getElementById('r-password').value
        })
    });

    let msg = 'Błąd rejestracji';
    if(res.ok){
        msg = 'Rejestracja OK';
        document.getElementById('r-username').value = "";
        document.getElementById('r-email').value = "";
        document.getElementById('r-display').value = "";
        document.getElementById('r-password').value = "";
    }
    document.getElementById('result').innerText = msg;

}


async function getUserPermissions(){
    const res = await fetch(/api/)
}

async function login() {
    const res = await fetch('/api/login', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            username: document.getElementById('l-username').value,
            password: document.getElementById('l-password').value
        })
    });

    const data = await res.json();

    if(res.ok){
        document.getElementById('l-username').value = "";
        document.getElementById('l-password').value = "";
    }

    document.getElementById('result').innerText =
        res.ok ? `Witaj ${data.user.display_name}` : data.error;
}

async function checkAuth() {
    const res = await fetch('/api/me');
    const data = await res.json();

    if (res.ok) {
        document.getElementById('result').innerText =
            `Zalogowany: ${data.user.display_name}`;
    }
}

async function logout() {
    const res = await fetch('/api/logout');
    console.log(res)
    if (res.ok) {
        document.getElementById('result').innerText = 'Wylogowano';
    }
    else
        document.getElementById('result').innerText = 'Nie udało się wylogować';
}

