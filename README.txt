INSTALACJA
Projekt jest customowym modułem do Drupala. Aby go zainstalować wystarczy zainstalować CMS Drupal 9 a folder smartbees_shop z zawartością umieścić w folderze /modules/custom. Następnie w Drupal w "Rozszerz" znajdujemy ten moduł i go instalujemy. Wszelkie wymagane bazy danych oraz tłumaczenia instalują się automatycznie.

KONFIGURACJA
Udajemy się się [domena]/order-checkout lub klikając w "konfiguruj" w zakładce "Rozszerz". Działanie strony według otrzymanej instrukcji.
 - logowanie uruchamia popup, jednak jest on nieaktywny
 - stwórz nowe konto otwiera dodatkowe pola do uzupełnienia
 - ze względów czasowych walidacji poddałem tylko pole "Telefon", zarówno front jak i back-endowo (tylko cyfry od 5 do 15)
 - po wybraniu metody dostawy uruchamia się wybór adekwatnych metod płatności
 - można zamieścić komentarz
 - potwierdź zakup ajaxowo dodaje dane i wyświetla w popupie numer zamówienia (o ile wszystko pójdzie jak trzeba, inaczej zostanie pokazany komunikat błędu)
 - formularz w RWD

ZASADA DZIAŁANIA
 - smartbees_shop.install instaluje puste bazy zaraz po zainstalowaniu modułu (jest nawet baza do kodów rabatowych jednak nieużywana)
 - src/Form/OrderCheckoutForm.php tutaj w metodzie buildForm widać cały formularz, a w submitForm jest zawarta cała logika zbierania danych z formularza i wysłanie ich w odpowiedniej formie do odpowiednich serwisów, finalnie zwracając wiadomość z numerem zamówienia
 - src/Service tutaj mamy dwie klasy odpowiednio dla tabel w bazie danych, jest tutaj zawarta logika dodawania danych
 - plik JS daje wsparcie do tego czego nie udało się osiągnąć w backend
 - plik CSS kompilowany z SCSS do nadania wyglądu stronie

PODSUMOWANIE
Jest wiele rzeczy do poprawy, takich jak szersza walidacja, dodatkowy adres dostawy, kod rabatowy, recaptcha itd... jednak wierzę że nie ma potrzeby dalej pokazywać swoich umiejętności bo pozostało już tylko poszerzyć istniejący kod (zdaje sobie sprawę że jest zapewne wiele miejsc do jego optymalizacji). Zależało mi głównie na czasie, stąd reszty nie wykonałem, natomiast proszę się nie martwić, abmicji mam aż nadto ;)
