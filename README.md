# DoBotMagicianForEducation

DOBOT Magician este un robot multifuncțional și versatil, conceput pentru a imbunătăți experiența educaționala în diverse domenii, în special în STEAM (Știință, Tehnologie, Inginerie, Artă și Mecanică), cu ajutorul paginii web ce oferă o experiență mult mai ușoară în a-l controla. DOBOT Magician permite elevilor să aplice teorie în practică prin experimente interactive și proiecte hands-on. Copiii pot explora funcționarea roboților, inclusiv aspecte precum controlul motoarelor, utilizarea senzorilor și execuția secvențelor de mișcare. Site-ul web este proiectat pentru a fi intuitiv și ușor de utilizat, facilitând interacțiunea elevilor cu brațul robotizat. În plus, pagină noastră oferă profesorilor șansă de a monitoriza progresul elevilor, evaluând performanțele.oriza progresul elevilor, evaluând performanțele.

## Design

![Screenshot](var/www/html/img/SitePreviewLogare.png)

![Screenshot](var/www/html/img/SitePreview.png)

## Funcționalități
- Opțiunea de logare pe pagina cun nume de utilizator și parolă
- Introducerea de coordonate pentru mișcarea robotului
- Afișarea în timp real a mișcării brațului
- Trimiterea a mai multor seturi de coordonate pentru o acțiune mai complexă mai complexă

## Proiectare

Proiectul nostru implică conectarea brațului robotic DOBOT Magician la un Raspberry Pi 4, care funcționează ca server și gestionează toate operațiunile. Raspberry-ul este plasat într-o carcasă 3D personalizată, proiectată și creată de noi pentru a s mula pe nevoile proiectului nostru și pentru a oferi un aspect placut
  
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
