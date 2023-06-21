# Ideje

## JSON u bazi podataka
* stanje igre će biti određeni objekt, npr. instanca klase `Stol` imena `stanje`
* kako bismo izbjegli object-relational mapping problematiku kod spremanja u bazu, možemo u neku tablicu staviti atribut čiji tip podatka je JSON i spremiti: `json_encode(stol)`
* pitat ću profesora je li to ok, ali ne bi trebalo biti problema
* kod dohvata iz baze se samo dekodira JSON u objekt tipa `Stol`

# Problemi