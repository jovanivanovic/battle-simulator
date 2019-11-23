<template>
    <div class="home container">

        <h3>Options</h3>
        <div class="options">
            <button @click="create">Create Game</button>
        </div>

        <h3>Games</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Alive Armies</th>
                <th>Status</th>
            </tr>

            <tr v-for="game in games" :key="game.id">
                <td class="monospace">
                    <router-link :to="{ name: 'Game', params: { id: game.id }}">{{ game.id }}</router-link>
                </td>
                <td>{{ game.army_count.alive }} / {{ game.army_count.total }}</td>
                <td>{{ statuses[game.status] }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { getAllGames, createGame } from "../services/games";

    export default {
        name: 'Home',
        data() {
            return {
                games: null,
                statuses: {
                    0: 'Ready',
                    1: 'In Progress',
                    2: 'Finished'
                },
            }
        },
        methods: {
            create() {
                createGame()
                    .then((data) => { this.games = data; })
                    .catch((error) => { console.log(error); });
            }
        },
        components: {

        },
        mounted() {
            getAllGames()
                .then((data) => { this.games = data; })
                .catch((error) => { console.log(error); });
        }
    }
</script>
