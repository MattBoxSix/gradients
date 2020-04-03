<template>
    <v-dialog v-model="dialog" max-width="700">
        <v-card>
            <v-form>
                <v-container>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="card.name"
                                label="Name of Gradient"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="color"
                                v-mask="mask"
                                hide-details
                                class="ma-0 pa-0"
                                solo
                            >
                                <template v-slot:append>
                                    <v-menu
                                        v-model="menu"
                                        top
                                        nudge-bottom="105"
                                        nudge-left="16"
                                        :close-on-content-click="false"
                                    >
                                        <template v-slot:activator="{on}">
                                            <div
                                                :style="swatchStyle"
                                                v-on="on"
                                            />
                                        </template>
                                        <v-card>
                                            <v-card-text class="pa-0">
                                                <v-color-picker
                                                    v-model="card.color1"
                                                    flat
                                                />
                                            </v-card-text>
                                        </v-card>
                                    </v-menu>
                                </template>
                            </v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="color"
                                v-mask="mask"
                                hide-details
                                class="ma-0 pa-0"
                                solo
                            >
                                <template v-slot:append>
                                    <v-menu
                                        v-model="menu"
                                        top
                                        nudge-bottom="105"
                                        nudge-left="16"
                                        :close-on-content-click="false"
                                    >
                                        <template v-slot:activator="{on}">
                                            <div
                                                :style="swatchStyle"
                                                v-on="on"
                                            />
                                        </template>
                                        <v-card>
                                            <v-card-text class="pa-0">
                                                <v-color-picker
                                                    v-model="card.color2"
                                                    flat
                                                />
                                            </v-card-text>
                                        </v-card>
                                    </v-menu>
                                </template>
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close"
                        >Cancel</v-btn
                    >
                    <v-btn color="blue darken-1" text @click="saveToServer"
                        >Save</v-btn
                    >
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: ['card'],
    data() {
        return {
            dialog: false,
            color: '#1976D2FF',
            mask: '!#XXXXXXXX',
        };
    },
    methods: {
        close() {
            this.dialog = false;
        },
        saveToServer() {
            let bodyFormData = new FormData();
            bodyFormData.set('name', this.card.name);
            bodyFormData.set('color1', this.card.color1);
            bodyFormData.set('color2', this.card.color2);
            var self = this;
            // add new card
            if (this.card.id === -1) {
                axios
                    .post('/api/gradients', bodyFormData)
                    .then(response => {
                        this.cards = this.cards.concat(response.data);
                        self.close();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            } else {
                // update card
                bodyFormData.append('_method', 'PUT');
                axios
                    .post('/api/gradients/' + this.card.id, bodyFormData)
                    .then(response => {
                        Vue.set(self.cards, self.activeCardIndex, self.card);
                        // Object.assign(self.activeCard, self.editedCard);
                        self.close();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
