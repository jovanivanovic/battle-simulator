import { Axios } from "../helpers/axios";

export function getAllGames() {
    return Axios.get(`/api/games`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            throw error;
        });
}

export function getGame(id) {
    return Axios.get(`/api/games/${id}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            throw error;
        });
}

export function createGame() {
    return Axios.post(`/api/games`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            throw error;
        });
}

export function addArmy(id, army) {
    return Axios.post(`/api/games/${id}/armies`, army)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            throw error;
        });
}

export function attack(id) {
    return Axios.post(`/api/games/${id}/attack`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            throw error;
        });
}

export function reset(id) {
    return Axios.post(`/api/games/${id}/reset`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            throw error;
        });
}
