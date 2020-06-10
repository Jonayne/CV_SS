<?php

/**
     * Devuelve el nombre completo de un usuario con las palabras
     * capitalizadas.
     *
     * @return string
     */
function formatName($user) {
    return ucfirst($user->nombre) . " " .
           ucfirst($user->apellido_paterno) . " " .
           ucfirst($user->apellido_materno);
}
