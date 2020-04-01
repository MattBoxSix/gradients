<template>
    <v-container>
        <v-row align="center" justify="center">
            <v-col cols md="11" class="pt-5">
                <v-card class="cardColor d-inline-block mx-auto">
                    <v-card-text>
                        <v-row>
                            <template>
                                <v-card
                                    v-for="card in orderedCards"
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
                                    <v-row>
                                        <v-col cols="8">
                                            <div class="px-2 pt-2">
                                                <span>
                                                    {{ card.name }}
                                                </span>
                                                <br />
                                                <span>
                                                    {{ card.color1 }} &#8594;
                                                    {{ card.color2 }}
                                                </span>
                                            </div>
                                        </v-col>
                                        <v-col cols="4">
                                            <div class="pt-3">
                                                <v-icon
                                                    small
                                                    class="mr-2"
                                                    @click="editItem(card)"
                                                >
                                                    mdi-square-edit-outline
                                                </v-icon>
                                                <v-icon
                                                    small
                                                    @click="deleteItem(card)"
                                                >
                                                    mdi-delete
                                                </v-icon>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </template>
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
        orderedCards: function() {
            return _.orderBy(this.cards, 'color1');
        },
    },
    created() {
        this.loadGradients();
    },
    watch: {
        dialog(val) {
            val || this.close();
        },
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
                        this.cards = res.data.gradients;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        saveToServer() {
            let bodyFormData = new FormData();
            bodyFormData.set('name', this.cards.name);
            bodyFormData.set('color1', this.cards.color1);
            bodyFormData.set('color2', this.cards.color2);
            axios
                .post('/api/gradients', bodyFormData)
                .then(response => {
                    this.cards = res.data.gradients.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        deleteItem(card) {
            const index = this.cards.indexOf(card);
            if (confirm('Are you sure you want to delete this item?')) {
                axios
                    .delete('/api/gradients/' + this.cards[index].id)
                    .then(response => {
                        this.cards.splice(index, 1);
                    })
                    .catch(error => {
                        console.log('Deleting error');
                    });
            }
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
