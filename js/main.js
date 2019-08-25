var data = false;

(function () {
    getData();
})();

function getData() {
    var result = {};
    $.ajax({
        type: 'GET',
        url: 'backend/request.php',
        data: {'get_data': true},
        dataType: 'json',
        async:false,
        success: function (response) {
            console.log(response);
            if(response.status === 'success') {
                data = response.data;
            } else {
                alert(response.message);
            }
        },
        error: function (response) {
            result.status = 'error';
            result.data = {};
            result.message = 'Cant get data';
            data = result;
        }
    });
}

var app = new Vue({
   el: '#app',
   data: {
       message: 'Привет, Vue!',
       tariffs: data.tariffs,
       tariff_types: data.tariff_types,
       selectedTariffKind: null,
       selectedTariffList: null,
       selectedTariffName: '',
       selectedTariff: null,
       selectedTariffData: []
   },
    mounted: function () {
        $('#tariff_types').show();
    },
    watch: {
        selectedTariffKind: function () {
          if(this.selectedTariffKind !== null && this.selectedTariffKind !== 'undefined'){
              this.getList();
          }
      },
      selectedTariff: function () {
          if(this.selectedTariff !== null && this.selectedTariff !== 'undefined'){
              console.log(this.selectedTariff);
              this.getTariff();
          }
      }
    },
    methods:{
       getList:function () {
           if(this.selectedTariffKind !== null) {
               this.selectedTariffName = this.tariff_types[this.selectedTariffKind].name;
               this.selectedTariffList = this.tariff_types[this.selectedTariffKind].types;
               $('#tariff_types').hide();
               $('#tariff_list').show();
           }
       },
       getTariff: function () {
           if(this.selectedTariff !== null){
               this.selectedTariffData = [];
               this.selectedTariffData.push(this.selectedTariffList[this.selectedTariff]);
               $('#tariff_list').hide();
               $('#tariff_info').show();
           }
       },
       getBackToTariffLists: function () {
           this.selectedTariffData = [];
           this.seletedTariff = null;
           $('#tariff_info').hide();
           $('#tariff_list').show();

       },
       getBackToTariffKinds: function () {
           this.selectedTariffName = '';
           this.selectedTariffList = null;
           this.selectedTariffKind = null;
           $('#tariff_list').hide();
           $('#tariff_types').show();
       },
        btnPress: function () {
           return true;
        }
    }
});
