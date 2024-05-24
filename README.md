
video.py
Server de streaming video folosind camera de pe Raspberry Pi
Pentru a capta frame-uri folosim biblioteca Picam2. Serverul transmite pe portul 8000 stream video in format mjpeg.
Serverul proceseaza si cereri HTTP tip POST iar informatia transmisa in format JSON este prelucrata si adaugata ca text incadrat intr-un dreptunghi peste matricea de pixeli din frame.

video-server.service
scriptul face ca  serverul de streaming sa ruleze in background ca service si sa porneasca automat la boot in urma activarii acestui serviciu (systemctl enable video-server)

Dobot.py
programul in python are ca argumente 
x - coordonata x (int)
y - coordonata y (int)
z - coordonata z (int)
r - rotatia capului (float)
s - ventuza sau gripperul (boolean)
u - userul (str)
argumentele sunt folosite pentru a transmite comanda de deplasare la coordoonatele x,y,z,r si pentru a transmite o cerere HTTP tip POST catre serverul de streaming cu mesajul ce va fi afisat, in format JSON
print_messaje(mesaj) - transmite cereri HTTP POST folosind libraria requests iar mesajul este convertit in format JSON cu ajutorul librariei json
dobot_move_to(x,y,z,r) -deplaseaza bratul la coordonatele respective este un program python ce foloseste o interfata multiplatforma pentru bratul robotic Dobot Magician

procesare_inregistrari.php
program scris in php care proceseaza cererile HTTP tip POST transmise de formularul de inregistrare.
numele de user este verificat sa nu contina spatii sau caractere speciale, apoi este verificata unicitatea numelui in baza de date de tip mysql
