<template>
    <v-container>
        <v-row align="center" justify="center">
            <v-col cols md="11" class="pt-5">
                <v-card class="cardColor d-inline-block mx-auto">
                    <v-card-text>
                        <v-row>
                            <v-card
                                v-for="card in cards"
                                :key="card.id"
                                class="col-6 col-lg-3 pa-0 card"
                                flat
                            >
                                <v-card-text
                                    style="height: 150px"
                                    :style="{
                                        'background-image': backgroundImage(
                                            card.color1,
                                            card.color2,
                                        ),
                                    }"
                                    flat
                                ></v-card-text>
                                <div class="px-2 pt-3">
                                    <span>
                                        {{ card.name }}
                                    </span>
                                    <br />
                                    <span>
                                        {{ card.color1 }} &#8594;
                                        {{ card.color2 }}
                                    </span>
                                </div>
                            </v-card>
                        </v-row>
                    </v-card-text>
                </v-card>                
                <div class="text-center py-3">
                    <v-btn small color="primary" @click.stop="dialog = true"
                        >Add New Gradient</v-btn
                    >
                </div>
                <v-dialog v-model="dialog" max-width="700">
                    <v-card>
                        <v-form>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="cards.name"
                                            label="Name of Gradient"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col cols="12" md="4">
                                        <v-select
                                            v-model="cards.color1"
                                            :items="colors"
                                            label="First Color"
                                        ></v-select>
                                    </v-col>

                                    <v-col cols="12" md="4">
                                        <v-select
                                            v-model="cards.color2"
                                            :items="colors"
                                            label="Second Color"
                                        ></v-select>
                                    </v-col>
                                </v-row>
                            </v-container>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close"
                                    >Cancel</v-btn
                                >
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="saveToServer"
                                    >Save</v-btn
                                >
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            cards: [],
            colors: [
                'red',
                'green',
                'blue',
                'yellow',
                'purple',
                'orange',
                'black',
                'grey',
                'pink',
            ],
        };
    },
    computed: {
        backgroundImage: () => (color1, color2) => {
            let bgImage =
                'linear-gradient(to top right, ' + color1 + ',' + color2 + ')';
            return bgImage;
        },
    },
    created() {
        this.loadGradients();
    },
    methods: {
        close() {
            this.dialog = false;
        },
        loadGradients() {
            if (axios == null) {
                return;
            }
            axios
                .get('/api/gradients')
                .then(res => {
                    if (res.status === 200) {
                        this.cards = res.data.gradients.data;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.cardColor {
    background-color: #e6e6e6;
}
.card {
    border: 5px solid #e6e6e6;
}
</style>
