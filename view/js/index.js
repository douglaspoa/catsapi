var app = new Vue({
    el: '#vueapp',
    data: {
        name: '',
        colors: '',
        create_name: '',
        create_colors: '',
        message: '',
        fields: ['id', 'name', 'colors', 'actions'],
        infoModal: {
            id: 'info-modal',
            title: '',
            content: '',
        },
        alert: 0,
        bordered: true,
        contacts: [],
    },


    mounted: function () {
        console.log('Hello from Vue!')
        this.getCats()
    },

    methods: {
        getCats: function(){
            axios.get('../')
                .then(function (response) {
                    app.contacts = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        info: function(item, button) {
            app.alert = 0;
            this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            this.infoModal.title =  "Editar dados";
            this.infoModal.name =  item.name;
            this.infoModal.colors =  item.colors;
            this.infoModal.id =  item.id;
            this.infoModal.content = JSON.stringify(item, null, 2)
        },
        deletar: function(item) {
            console.log(item);
            axios.delete('../'+item)
                .then(function (response) {
                    console.log(response.data);
                    app.getCats();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        editCats: function(id){

            var name = this.$refs.form.name.value;
            var colors = this.$refs.form.colors.value;

            cat =
                [
                    {
                        "name": name,
                        "colors": [colors]
                    }
                ];
            axios({
                method: 'patch',
                url: '../'+id,
                data: cat,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
                .then(function (response) {
                    if (response.status === 400) {
                        app.alert = 4;
                        app.message = response.data
                    } else {
                        //handle success
                        console.log(response)
                        app.getCats()
                        app.alert = 1
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response)
                    app.message = response.data
                    app.alert = 4
                });
        },
        createCats: function(){
            app.alert = 0;
            console.log(this.$refs.create_form.create_name);
            var name = this.$refs.create_form.create_name.value;
            var colors = this.$refs.create_form.create_colors.value;

            cat =
                [
                    {
                        "name": name,
                        "colors": [colors]
                    }
                ];
            console.log(cat)

            axios({
                method: 'post',
                url: '../',
                data: cat,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
                .then(function (response) {
                    if (response.status === 400) {
                        app.alert = 3;
                        app.message = response.data
                    } else {
                        //handle success
                        app.getCats()
                        app.alert = 2;
                        app.resetForm();
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response)
                    app.message = response.data
                    app.alert = 3
                });
        },
        resetForm: function(){
            this.create_name = '';
            this.create_colors = '';
        }
    }
})