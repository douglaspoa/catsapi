var app = new Vue({
    el: '#vueapp',
    data: {
        name: '',
        color: '',
        create_name: '',
        create_color: '',
        message: '',
        fields: ['id', 'name', 'color', 'actions'],
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
            axios.get('api/GET')
                .then(function (response) {
                    console.log(response.data.body);
                    app.contacts = response.data.body;
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
            this.infoModal.color =  item.color;
            this.infoModal.id =  item.id;
            this.infoModal.content = JSON.stringify(item, null, 2)
        },
        deletar: function(item) {
            console.log(item);
            axios.delete('api/DELETE/'+item)
                .then(function (response) {
                    console.log(response.data.body);
                    app.getCats();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        editCats: function(id){

            var name = this.$refs.form.name.value;
            var color = this.$refs.form.color.value;

            cat =
                [
                    {
                        "name": name,
                        "color": color
                    }
                ];

            axios({
                method: 'patch',
                url: 'api/PATCH/'+id,
                data: cat,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
                .then(function (response) {
                    if (response.data.status_code = 400) {
                        app.alert = 4;
                        app.message = response.data.message
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
                    app.alert = 4
                });
        },
        createCats: function(){
            app.alert = 0;
            console.log(this.$refs.create_form.create_name);
            var name = this.$refs.create_form.create_name.value;
            var color = this.$refs.create_form.create_color.value;

            cat =
                [
                    {
                        "name": name,
                        "color": color
                    }
                ];

            axios({
                method: 'post',
                url: 'api/POST',
                data: cat,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
                .then(function (response) {
                    if (response.data.status_code = 400) {
                        app.alert = 3;
                        app.message = response.data.message
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
                    app.alert = 3
                });
        },
        resetForm: function(){
            this.create_name = '';
            this.create_color = '';
        }
    }
})