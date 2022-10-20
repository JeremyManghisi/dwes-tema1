<?php
//Creamos la variable tablero con la estructura que vamos a utilizar.
$tablero = [
    [" ", " ", " "],
    [" ", " ", " "],
    [" ", " ", " "]
];



/**
 * Se encarga de crear el tablero, con echo se hace la estructura y se concatena con la posicion del array para que se muestre la X y la O.
 */

function crearTablero(array $tablero): void
{
    echo "+-----+-----+-----+\n" .
        "|  " . $tablero[0][0] . "  |  " . $tablero[0][1] . "  |   " . $tablero[0][2] . " |\n" .
        "+-----+-----+-----+\n" .
        "|  " . $tablero[1][0] . "  |  " . $tablero[1][1] . "  |   " . $tablero[1][2] . " |\n" .
        "+-----+-----+-----+\n" .
        "|  " . $tablero[2][0] . "  |  " . $tablero[2][1] . "  |   " . $tablero[2][2] . " |\n" .
        "+-----+-----+-----+\n";
}
/**
 * El cambio de turno se encarga de devolver el contrario al turno actual, si el turno actual es X el siguiente será O, y al revés.
 */
function cambioDeTurnos(string $turno): string
{
    return $turno == "X" ? "O" : "X";
}
/**
 * Esta función comprueba si hay una victoria en el tablero. Comprueba todas las posibilidades:
 * - Fila 1, 2 y 3
 * - Columna 1, 2 y 3
 * - Las dos diagonales
 * 
 * Devuelve:
 * - "X" si hay victoria de las X
 * - "O" si hay victoria de las O
 */
function comprobarVictoria(array $tablero, string $turno): string
{
    //Validacion horizontal
    for ($i = 0; $i < 3; $i++) {
        if ($tablero[$i][0] == $turno && $tablero[$i][1] == $turno && $tablero[$i][2] == $turno) {
            return $tablero[$i][0];
        }
    }
    //Validacion vertical
    for ($i = 0; $i < 3; $i++) {
        if ($tablero[0][$i] == $turno && $tablero[1][$i]  == $turno && $tablero[2][$i] == $turno) {
            return $tablero[0][$i];
        }
    }

    //Validacion Diagonal de izquierda a derecha
    if ($tablero[0][0] == $turno && $tablero[1][1] == $turno && $tablero[2][2] == $turno) {
        return $tablero[2][2];
    }

    //Validacion Diagonal de Derecha a Izquierda
    if ($tablero[0][2] == $turno && $tablero[1][1] == $turno && $tablero[2][0] == $turno) {
        return $tablero[2][0];
    }
    return " ";
}
/**
 * Esta función devuelve true si la posicion en el espacio al que se quiere acceder en la matriz está vacía, se utiliza para que no se pueda escribir la misma posición 2 veces.
 */
function estaLibrePosicion(array $tablero, int $x, int $y): bool
{
    return $tablero[$x][$y] == " ";
}
/**
 * Esta función devuelve true si todo el tablero se encuentra lleno, se usa como finalización para el juego.
 */
function tableroLleno(array $tablero): bool
{
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($tablero[$i][$j] == " ") {
                return false;
            }
        }
    }
    return true;
}
/** 
 * Comprobación
 * Se piden filas y columnas y se guardan en variables.
 * Si filas es un número y el valor introducido es mayor o igual a 0 y menor que 3 se ejecuta.
 * Si columnas es un número y el valor introducido es mayor o igual a 0 y menor que 3 se ejecuta.
 * Se le pasa la función estaLibrePosicion que comprueba si la posición está ocupada.
 */
function pedirMovimiento(array $tablero): array
{
    do {
        do {
            echo "\n";
            echo "Introduce un número y que sea entre 0 y 2 \n";
            echo "Escribe la fila y columna separadas por un espacio: ";
            fscanf(STDIN, "%d %d", $fila, $columna);
        } while (!is_numeric($fila) || $fila < 0 || $fila > 2 || !is_numeric($columna) || $columna < 0 || $columna > 2);
    } while (!estaLibrePosicion($tablero, $fila, $columna));

    return [$fila, $columna];
}
$turno = "X";

/**
 * Ciclo del juego, si el tablero esta lleno finaliza el juego.
 * Se comprueba que ha ganado si es igual a X u O o si ocurre un empate.
 * Se encarga de pintar las X y O mediante x e y.
 */
    do{
    crearTablero($tablero);
    $turno = cambioDeTurnos($turno);
    $pos = pedirMovimiento($tablero);
    $x = $pos[0];
    $y = $pos[1];
    echo "Es el turno de $turno. \n";
    $tablero[$x][$y] = $turno;
    if (comprobarVictoria($tablero, $turno) == "X") {
        crearTablero($tablero);
        echo "Felicidades, ha ganado X. \n";
        break;
    } else if (comprobarVictoria($tablero, $turno) == "O") {
        crearTablero($tablero);
        echo "Felicidades, ha ganado O. \n";
        break;   
    }
    if(tableroLleno($tablero)){
        crearTablero($tablero);
        echo "Ha ocurrido un empate.";
        break;
    }

} while (!tableroLleno($tablero));