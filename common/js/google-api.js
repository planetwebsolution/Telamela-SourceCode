
    var map;
    var marker;
    var geocoder;
    function initMap(mapId) {

    }


    function setMapObj(mapId, options) {

        var map = new google.maps.Map(document.getElementById(mapId), {
            //center: new google.maps.LatLng(36.835769, 10.247693),
            zoom: 4,
        });
        return map;
    }

    function geocodeAddress(geocoder, resultsMap, CountryName) {
        var infowindow = new google.maps.InfoWindow;
        //var address = document.getElementById('address').value;
        geocoder.geocode({'address': CountryName}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {

                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });

                infowindow.setContent(results[0].formatted_address);
                infowindow.open(resultsMap, marker);


            } else {
                console.log(status);
//                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    $("#myModal").on("shown.bs.modal", function (event) {

        /* Start For Map Api*/
        var geocoder = new google.maps.Geocoder();
        
        if (fromTo == 'from') {
            var CountryName = $('#frmcountryid_' + modelj + '_' + modeli + ' :selected').text();
            //address = address;
            //console.log(address,CountryName);
            if (CountryName != 'Select Country') {
                address = CountryName;
            }
            
            var StateName = $('#frmStateid_' + modelj + '_' + modeli + ' :selected').text();
            if (StateName != 'Select State') {
                address = address + ',' + StateName;
            }

            var CityName = $('#frmcityid_' + modelj + '_' + modeli + ' :selected').text();
            if (CityName != 'Select City') {
                address = address + ',' + CityName;
            }
        } else if (fromTo == 'to') {
            var CountryName = $('#tocountryid_' + modelj + '_' + modeli + ' :selected').text();
            
            if (CountryName != 'Select Country') {
                address = CountryName;
            }
            
            var StateName = $('#toStateid_' + modelj + '_' + modeli + ' :selected').text();
            if (StateName != 'Select State') {
                address = address + ',' + StateName;
            }
            var CityName = $('#tocityid_' + modelj + '_' + modeli + ' :selected').text();
            if (CityName != 'Select City') {
                address = address + ',' + CityName;
            }
        }
        //console.log(address);
        var mapDivId = 'map';
        var returnMap = setMapObj(mapDivId);
        geocodeAddress(geocoder, returnMap, address);

        google.maps.event.addListener(returnMap, 'click', function (event) {
            placeMarker(event.latLng);
        });
        /* End For Map Api*/
//        google.maps.event.trigger(returnMap, "resize");
//
//        var currCenter = returnMap.getCenter();
//        google.maps.event.trigger(returnMap, "resize");
//        returnMap.setCenter(currCenter);
    });
    function placeMarker(location) {
        if (marker) { //on vérifie si le marqueur existe
            marker.setPosition(location); //on change sa position
        } else {
            marker = new google.maps.Marker({//on créé le marqueur
                position: location,
                map: map
            });
        }
        //document.getElementById('lat').value = location.lat();
        //document.getElementById('lng').value = location.lng();
        getAddress(location);
    }

    function getAddress(latLng) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {

                if (results[0]) {
                    getSeparateAdd(results);
                    //document.getElementById("address").value = results[0].formatted_address;
                }
                else {
//                    document.getElementById("address").value = "No results";
                    console.log('Wrong Selection');
                }
            }
            else {
//                document.getElementById("address").value = status;
                console.log('Wrong Selection');
            }
        });
    }

    function getSeparateAdd(add) {
        console.log(add);
        //$.each(add, function (key, value) {
        $.each(add[0].address_components, function (k, val) {

            if (val.types[0] == 'country') {
                var getCountryName = val.long_name;
                var getCountryShortName = val.short_name;
            }
            if (val.types[0] == 'administrative_area_level_1') {
                var getStateName = val.long_name;
                var getStateShortName = val.short_name;
            }
            if (val.types[0] == 'administrative_area_level_2') {
                var getCityName = val.long_name;
                var getCityShortName = val.short_name;
            }
            if (val.types[0] == 'locality') {
                var getCityName1 = val.long_name;
                var getCityShortName1 = val.short_name;
            }

            if (fromTo == 'from') {
                $('#frmcountryid_' + modelj + '_' + modeli + ' option').filter(function () {
                    if (typeof getCountryName != 'undefined') {
                        if ($(this).text() == getCountryName) { // match whole name
                            return ($(this).text() == getCountryName);
                        } else if (getCountryName.indexOf($(this).text()) > -1) { // match words in whole string
                            return 1;
                        } else { // match character
                            return (getCountryName.match(new RegExp($(this).text(), 'gi')));
                        }
                    }
                    //return ($(this).text() == getCountryName);
                }).attr('selected', true).trigger("change");

                setTimeout(function () {
                    $('#frmStateid_' + modelj + '_' + modeli + ' option').filter(function () {
                        if (typeof getStateName != 'undefined') {
                            if ($(this).text() == getStateName) {
                                return($(this).text() == getStateName);
                            } else if (getStateName.indexOf($(this).text()) > -1) {
                                return 1;
                            } else {
                                return(getStateName.match(new RegExp($(this).text(), 'gi')));
                            }
                        }
                        //return ($(this).text() == getStateName);
                    }).attr('selected', true).trigger("change");
                }, 1000);

                //console.log(getCityName, getCityName1);
                setTimeout(function () {
                    
                    $('#frmcityid_' + modelj + '_' + modeli + ' option').filter(function () {
                        if (typeof getCityName != 'undefined') {
                            if ($(this).text() == getCityName) {
                                return($(this).text() == getCityName);
                            } else if (getCityName.indexOf($(this).text()) > -1) {
                                return 1;
                            } else {
                                return(getCityName.match(new RegExp($(this).text(), 'gi')));
                            }
                        } else if (typeof getCityName1 != 'undefined') {
                            //console.log($(this).text(), getCityName1);
                            if ($(this).text() == getCityName1) {
//                                return($(this).text() == getCityName1);
                                return 1;
                            }
//                            else if ($.inArray($(this).text(), getCityName1.split(' ')) != -1) {
//                                return 1;
//                            } 
                            else if (getCityName1.indexOf($(this).text()) > -1) {
                                return 1;
                            } else {
                                return(getCityName1.match(new RegExp($(this).text(), 'gi')));
                            }
                            //return(getCityName1.match(new RegExp($(this).text(), 'gi')));
                        }
                        //}
                        //return ($(this).text() == getCityName || $(this).text() == getCityName1);
                    }).attr('selected', true).trigger("change");
                }, 2000);

                //$('#frmcountryid_' + modelj + '_' + modeli).val('22');
            }
            if (fromTo == 'to') {
                $('#tocountryid_' + modelj + '_' + modeli + ' option').filter(function () {
                    if (typeof getCountryName != 'undefined') {
                        if ($(this).text() == getCountryName) { // match whole name
                            return ($(this).text() == getCountryName);
                        } else if (getCountryName.indexOf($(this).text()) > -1) { // match words in whole string
                            return 1;
                        } else { // match character
                            return (getCountryName.match(new RegExp($(this).text(), 'gi')));
                        }
                    }
                    //return ($(this).text() == getCountryName);
                }).attr('selected', true).trigger("change");

                setTimeout(function () {
                    $('#toStateid_' + modelj + '_' + modeli + ' option').filter(function () {
                        if (typeof getStateName != 'undefined') {
                            if ($(this).text() == getStateName) {
                                return($(this).text() == getStateName);
                            } else if (getStateName.indexOf($(this).text()) > -1) {
                                return 1;
                            } else {
                                return(getStateName.match(new RegExp($(this).text(), 'gi')));
                            }
                        }
                        //return ($(this).text() == getStateName);
                    }).attr('selected', true).trigger("change");
                }, 1000);

                setTimeout(function () {
                    $('#tocityid_' + modelj + '_' + modeli + ' option').filter(function () {
                        if (typeof getCityName != 'undefined') {
                            if ($(this).text() == getCityName) {
                                return($(this).text() == getCityName);
                            } else if (getCityName.indexOf($(this).text()) > -1) {
                                return 1;
                            } else {
                                return(getCityName.match(new RegExp($(this).text(), 'gi')));
                            }
                        } else if (typeof getCityName1 != 'undefined') {
                            if ($(this).text() == getCityName1) {
                                return($(this).text() == getCityName1);
                            } else if (getCityName1.indexOf($(this).text()) > -1) {
                                return 1;
                            } else {
                                return(getCityName1.match(new RegExp($(this).text(), 'gi')));
                            }
                            //return(getCityName1.match(new RegExp($(this).text(), 'gi')));
                        }
                        //return ($(this).text() == getCityName);
                    }).attr('selected', true).trigger("change");
                }, 2000);
                //$('#frmcountryid_' + modelj + '_' + modeli).val('22');
            }



        });

        //});
    }



