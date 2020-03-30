<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 pt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div
                                v-for="card in cards"
                                :key="card.id"
                                class="col-6 col-lg-3 pt-3" 
                                                             
                            >
                                <div class="card-body"
                                style="height: 100px"
                                :style="{'background-image': backgroundImage(card.color1, card.color2)}"></div>
                                <div class="card-footer">
                                    <span>
                                        {{ card.name }}
                                    </span>
                                    <br />
                                    <span>
                                        {{ card.color1 }} &#8594; {{
                                            card.color2
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center py-3">
                    <button type="button" class="btn btn-success">
                        Add New Gradient
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cards: [
                {name: 'Name of thing', color1: '#ff0000', color2: '#ffff00'},
                {name: 'Name of thing', color1: '#b3b3ff', color2: '#0000e6'},
                {name: 'Name of thing', color1: '#ff0000', color2: '#ffff00'},
                {name: 'Name of thing', color1: '#ff0000', color2: '#ffff00'},
                {name: 'Name of thing', color1: '#ff0000', color2: '#ffff00'},
                {name: 'Name of thing', color1: '#ff0000', color2: '#ffff00'},
                {name: 'Name of thing', color1: '#ff0000', color2: '#ffff00'},
                {name: 'Name of thing', color1: '#ff0000', color2: '#ffff00'},
            ],
        };
    },
    computed: {
      backgroundImage: () => (color1, color2) => {
        let bgImage = 'linear-gradient(to top right, '+ color1+',' +color2 +')';
        return bgImage;
      }
    }
};
</script>

<style lang="scss" scoped>
.cardGradient {
    background-image: linear-gradient(to top right, #ff0000, #ffff00);
    height: 100px;
}
</style>
