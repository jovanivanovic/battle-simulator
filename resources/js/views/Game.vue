<template>
    <div class="game container">
        <header>
            <h1>{{ game.id }}</h1>
            <div class="badge">{{ statuses[game.status] }}</div>
        </header>

        <h3>Options</h3>
        <div class="options">
            <router-link :to="{ name: 'AddArmy', params: { id: game.id }}"><button>Add Army</button></router-link>
            <button @click="attack">Attack</button>
            <button @click="reset">Reset</button>
        </div>

        <h3>Armies</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Starting Units</th>
                <th>Alive Units</th>
                <th>Attack Chance</th>
                <th>Attack Damage</th>
                <th>Reload Time</th>
                <th>Strategy</th>
            </tr>

            <tr v-for="army in game.armies" :key="army.id" :defeated="army.is_defeated">
                <td class="monospace">{{ army.id }}</td>
                <td>{{ army.name }}</td>
                <td>{{ army.starting_units }}</td>
                <td>{{ army.alive_units }}</td>
                <td>{{ army.attack_chance }}%</td>
                <td>{{ army.attack_damage }}</td>
                <td>{{ army.reload_time }} seconds</td>
                <td>{{ strategies[army.strategy] }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { getGame, attack, reset } from "../services/games";

    export default {
        name: 'Game',
        data() {
            return {
                statuses: {
                    0: 'Ready',
                    1: 'In Progress',
                    2: 'Finished'
                },
                strategies: {
                    0: 'Random',
                    1: 'Weakest',
                    2: 'Strongest'
                },
                game: null,
            }
        },
        computed: {

        },
        methods: {
            attack() {
                attack(this.game.id)
                    .then((data) => {
                        if (data.error) {
                            this.$toasted.show(data.error, { type: 'error', position: 'bottom-right', duration: 2500 });
                        } else {
                            this.game = data.game;
                            console.log(data.logs);
                        }
                    })
                    .catch((error) => { console.log(error); });
            },
            reset() {
                reset(this.game.id)
                    .then((data) => { this.game = data; })
                    .catch((error) => { console.log(error); });
            }
        },
        components: {

        },
        mounted() {
            getGame(this.$route.params.id)
                .then((data) => { this.game = data; })
                .catch((error) => { console.log(error); });
        }
    }
</script>
