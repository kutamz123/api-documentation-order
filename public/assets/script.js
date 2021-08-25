const username = "24|gnqP91sPxVFIcIUhMa5BXdI6RGHC6mrW7ojrwkMX";
        fetch("http://127.0.0.1:8000/api/orders",{
                method : "GET",
                headers : {
                    'Authorization': 'Bearer ' + username,
                    "Content-Type": "application/json",
                    "Accept": "application/json"
            }
        })
            .then(response => response.json())
            .then(data => console.log(data));
