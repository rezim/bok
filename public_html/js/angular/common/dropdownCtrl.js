DropDownCtrl = function ($scope) {
    this.selected = {};

    this.onSelect = function(selected) {
        this.selected = selected;
    }
};

app.controller('DropDownCtrl', DropDownCtrl);