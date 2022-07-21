<?php
    
    //Objective
    let listView = document.createElement("div");
    listView.className = "single-kp-container-box";

    if (theKP.mcActive === "Y") 
    {
        let mcContainerBox = document.createElement("div"); 
        mcContainerBox.className = "mc-container-box";

        let mcHeader = document.createElement("div");  
        mcHeader.className = "mc-header";

        if (theKP.mcFree === "Y") 
        {
            mcHeader.innerHTML = theKP.mcDiscount + words["DiscountOrFree"];

        } else
        {
            mcHeader.innerHTML = theKP.mcDiscount + words["Discount"];
        }

        let mcImagePath = "";
        
        if (theKP.mcImageKey.length > 0)
        {
            mcImagePath = s3Path + mcImageFolder + theKP.mcImageKey + ".jpg";
            
        } else
        {
            mcImagePath = "img/group-default-img.png";
        }
        
        let mcImgFrame = document.createElement("div");
        mcImgFrame.className = "mc-img";

        let mcImg = document.createElement("img");
        mcImg.src = mcImagePath; 
        mcImgFrame.appendChild(mcImg);

        let mcMsg = document.createElement("div");
        mcMsg.className = "mc-msg";
        mcMsg.innerHTML = theKP.mcMsg;

        let mcBtn = document.createElement("div");
        mcBtn.className = "mc-btn clickable noselect";
        mcBtn.setAttribute("onclick", "showQRcode(\"" + theKP.KPID + "\")");
        mcBtn.innerHTML = words["PresentCode"];

        listView.appendChild(mcContainerBox);
        mcContainerBox.appendChild(mcHeader);
        mcContainerBox.appendChild(mcImgFrame);
        mcContainerBox.appendChild(mcMsg);
        mcContainerBox.appendChild(mcBtn);
    }

    //UI elements
    let boxContent = document.createElement("div");
    boxContent.className = "kp-container-box-content";

    let pointDetails = document.createElement("div");
    pointDetails.className = "kp-point-details";

    let rowSection = document.createElement("div");
    rowSection.className = "row noselect";

    let userDetails = document.createElement("div");
    userDetails.className = "kp-user-details";

    let profilepicPath = "";
    
    
    if (theKP.profilePicKey.length > 0)
    {
        profilepicPath = s3Path + profilePicFolder + theKP.profilePicKey + ".jpg";
        
    } else
    {
        profilepicPath = "img/user-default-img.png";
    }

    let userImgContainer = document.createElement("div");
    userImgContainer.id = "kp-user-profilepic";

    let userImg = document.createElement("img");
    userImg.className = "kp-user-profilepic noselect notap";
    userImg.setAttribute("onmousedown", "return false");
    userImg.src = profilepicPath;

    let usernameCol = document.createElement("div");
    usernameCol.className = "kp-username-col";


    let usernameLabel = document.createElement("div");
    usernameLabel.className = "kp-username";
    usernameLabel.id = "kp-username";
    usernameLabel.innerHTML = theKP.creatorName;

   
    let premiumTag = document.createElement("div");

    if (theKP.pointClass === "P")
    {
        premiumTag.className = "kp-premium-tag";
        premiumTag.id = "kp-premium-tag";
        premiumTag.innerHTML = words["Premium"];
    }

    let shareBtn = document.createElement("div");
    shareBtn.className = "kp-share-btn-single-list clickable";
    shareBtn.setAttribute("onclick", "shareLink(\"" + theKP.pointLink + "\", false)");

    let shareBtnImg = document.createElement("img");
    shareBtnImg.className = "noselect notap";
    shareBtnImg.src = "img/share-icon.png";
    
    userDetails.appendChild(userImgContainer);
    userImgContainer.appendChild(userImg);
    userDetails.appendChild(usernameCol);
    usernameCol.appendChild(usernameLabel);

    if (theKP.pointClass === "P")
    {
        usernameCol.appendChild(premiumTag);
    }

    shareBtn.appendChild(shareBtnImg);

    rowSection.appendChild(userDetails);
    rowSection.appendChild(shareBtn);

    let topicLabel;

    if (theKP.topic.length > 0)
    {
        topicLabel = document.createElement("div");
        topicLabel.id = "kp-title-full";
        topicLabel.className = "kp-title-full noselect notap";
        topicLabel.innerHTML = theKP.topic;
    }

    //Start here
    let placeDetailsSection = document.createElement("div");
    placeDetailsSection.className = "place-details";

    if (theKP.price.length > 0) 
    {
        let priceRow = document.createElement("div");
        priceRow.className = "price";

        let priceIcon = document.createElement("div");
        priceIcon.className = "place-details-icon noselect notap";

        let priceImg = document.createElement("img");
        priceImg.src = "img/price-icon.png";

        let priceInfo = document.createElement("div");
        priceInfo.className = "place-details-font";
        priceInfo.innerHTML = theKP.price;

        priceRow.appendChild(priceIcon);
        priceIcon.appendChild(priceImg);
        priceRow.appendChild(priceInfo);
        placeDetailsSection.appendChild(priceRow);
    }
    
    let addressRow = document.createElement("div");
    addressRow.className = "address";

    let addressIcon = document.createElement("div");
    addressIcon.className = "place-details-icon noselect notap";
    
    let addressImg = document.createElement("img");
    addressImg.src = "img/address-icon.png";

    let addressInfo = document.createElement("div");
    addressInfo.className = "place-details-font";
    addressInfo.innerHTML = theKP.address;

    addressRow.appendChild(addressIcon);
    addressIcon.appendChild(addressImg);
    addressRow.appendChild(addressInfo);
    placeDetailsSection.appendChild(addressRow);

    if (theKP.phone.length > 0) 
    {
        let phoneRow = document.createElement("div");
        phoneRow.className = "phone";

        let phoneIcon = document.createElement("div");
        priceIcon.className = "place-details-icon noselect notap";

        let phoneImg = document.createElement("img");
        phoneImg.src = "img/phone-icon.png";

        let phoneInfo = document.createElement("div");
        phoneInfo.className = "place-details-font";
        phoneInfo.innerHTML = theKP.phone;

        phoneRow.appendChild(phoneIcon);
        phoneIcon.appendChild(phoneImg);
        phoneRow.appendChild(phoneInfo);
        placeDetailsSection.appendChild(phoneRow);
    }

    if (theKP.web.length > 0)
    {
        let theLink = theKP.web;
        
        if (theLink.substring(0, 4) !== "http")
        {
            theLink = "http://" + theLink;
        }

        let linkRow = document.createElement("div");
        linkRow.className = "web";

        let linkIcon = document.createElement("div");
        linkIcon.className = "place-details-icon noselect notap";

        let linkImg = document.createElement("img");
        linkImg.src = "img/web-icon.png";

        let linkInfo = document.createElement("div");
        linkInfo.className = "place-details-font";
        //ask matthew if this is correct
        linkInfo.setAttribute('href', theLink);
        linkInfo.innerHTML = theKP.web;

        linkRow.appendChild(linkIcon);
        linkIcon.appendChild(linkImg);
        linkRow.appendChild(linkInfo);
        placeDetailsSection.appendChild(linkRow); 
    }

    if (theKP.hours.length > 0)
    {
        let hoursRow = document.createElement("div");
        hoursRow.className = "hours";

        let hoursIcon = document.createElement("div");
        hoursIcon.className = "place-details-icon noselect notap";

        let hoursImg = document.createElement("img");
        hoursImg.src = "img/hours-icon.png";

        //ask matthew if this is an ok variable name and if its correct
        let hoursInfo = document.createElement("div");
        hoursInfo.className = "place-details-font clickable";
        hoursInfo.setAttribute("onclick", "toggleHourDetails()");
    

        //have no clue ask matthew
        if (theKP.hours[dayOfWeek].length > 0)
        {
            theKP.hours[dayOfWeek].forEach(function (todayTime)
            {
                hoursInfo.innerHTNL += todayTime + " ";
            });  
        } else
        {
            hoursInfo.innerHTML += words["Closed"];
        }
        //might need to append here???append to hoursInfo then to hoursRow
        hoursInfo.innerHTML = "(" + weekdayText[dayOfWeek] + ")";

        hoursRow.appendChild(hoursIcon);
        hoursIcon.appendChild(hoursImg);
        hoursRow.appendChild(hoursInfo);
        placeDetailsSection.appendChild(hoursRow);//do i need to append this here?

        

        let hoursDetails = document.createElement("div");
        hoursDetails.id = "single-point-hour-details";
        hoursDetails.className = "hour-details place-details-font";
        hourDetails.setAttribute("style", "display:none");

        let dayCol = document.createElement("div");
        dayCol.className = "time-day-col";


        let hoursDays = document.createElement("div");
        hoursDays.className = "hour-day";

        for (let i = 0; i < weekdayText.length; i++)
        {
            hoursDays.innerHTML += weekdayText[i]; 
        }

        let hoursCol = document.createElement("div");
        hoursCol.className = "time-hour-col";

        theKP.hours.forEach(function (aDay, idx)
        {
            let hoursEl = document.createElement("div");
            hoursEl.className = "hour-el";

            if (aDay.length > 0)
            {
                aDay.forEach(function (aTime)
                {
                    hoursEl.innerHTML += aTime + " ";
                });
            } else
            {
                hoursEl.innerHTML += words["Closed"];
            }

            hoursCol.appendChild(hourEl);
        });
 
        hoursDetails.appendChild(dayCol);
        dayCol.appendChild(hoursDays);
        hoursDetails.appendChild(hoursCol);
        placeDetailsSection.appendChild(hourDetails);
    }

    //its wrong because you need to first do the big one
    userDetails.appendChild(placeDetailsSection);

    rowSection.appendChild(userDetails);
    pointDetails.appendChild(rowSection);

    boxContent.appendChild(pointDetails);
    listview.appendChild(boxContent);


    let klickSection = document.createElement("section");
    klickSection.id = "klicks-section";

    theKP.theKlicks.forEach(function (aKlick) 
    {
        let klickContainerBox = document.createElement("div");
        klickContainerBox.className = "klick-container-box noselect";

        var imgDimen = aKlick.imgDimen.split(":", 2);
        var imgHeight = (singlePointListWidthInt - (singleViewImgMarginInt * 2)) / imgDimen[0] * imgDimen[1];

        let  klickPhoto  = document.createElement("div");
        klickPhoto.className = "klick-photo";
        //klickPhoto.setAttribute("style", "height:")
        klickPhoto.style[height] = imgHeight; 
        klickPhoto.style[px;margin-left] = singleViewImgMarginInt;
        klickPhoto.style[px;margin-right] = singleViewImgMarginInt; 
        
        let klickImg = document.createElement("img");
        klickImg.src = ""+ s3Path + imageFolder + aKlick.klickImgKey + ".jpg";
        klickPhoto.className = "noselect notap";
        klickPhoto.setAttribute("onmouseown", "return false");

        if (aKlick.caption.length > 0)
        {
            let klickCc = document.createElement("div");
            klickCc.className = "klick-caption";
            klickCc.innerHTML = aKlick.caption;
        }

        klickContainerBox.appendChild(klickPhoto);
        klickPhoto.appendChild(klickImg);
        klickContainerBox.appendChild(klickCc);
      
    }

    klickSection.appendChild(klickContainerBox);
    listview.appendChild(klickSection);

    //section not changed
    let savePointBtn = document.getElementById("save-point-btn");
    
    if (theKP.saved === "Y")
    {
        savePointBtn.classList.add("point-saved");
        savePointBtn.classList.remove("point-not-saved");
        
        savePointBtn.innerHTML = "<img src='img/bookmark-filled-icon.png' class='noselect notap'/>";
        
    } else
    {
        savePointBtn.classList.add("point-not-saved");
        savePointBtn.classList.remove("point-saved");
        
        savePointBtn.innerHTML = "<img src='img/bookmark-icon.png' class='noselect notap'/>";
    }
    
    let newSavePointBtn = savePointBtn.cloneNode(true);
    savePointBtn.parentNode.replaceChild(newSavePointBtn, savePointBtn);

    newSavePointBtn.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
                                                                    
        savePoint(newSavePointBtn, theKP.KPID, e);
                                                                                                                    
    });
                
    listView += listView;

    

    



    //Original
    let listView = "<div class='single-kp-container-box'>";
    
    if (theKP.mcActive === "Y")
    {
        listView = listView + "<div class='mc-container-box'>";
        
        if (theKP.mcFree === "Y")
        {
            listView = listView + "<div class='mc-header'>" + theKP.mcDiscount + words["DiscountOrFree"] + "</div>";

        } else
        {
            listView = listView + "<div class='mc-header'>" + theKP.mcDiscount + words["Discount"] + "</div>";
        }  

        let mcImagePath = "";
        
        if (theKP.mcImageKey.length > 0)
        {
            mcImagePath = s3Path + mcImageFolder + theKP.mcImageKey + ".jpg";
            
        } else
        {
            mcImagePath = "img/group-default-img.png";
        }
        
        listView = listView + "<div class='mc-img'><img src='" + mcImagePath + "'></div>";
        
        listView = listView + "<div class='mc-msg'>" +  theKP.mcMsg + "</div>";
        
        listView = listView + "<div class='mc-btn clickable noselect' onclick='showQRcode(\"" + theKP.KPID + "\")'>" +  words["PresentCode"] + "</div>";
        
        listView = listView + "</div>";
    }
    
    listView = listView + "<div class='kp-container-box-content'>";
    
    listView = listView + "<div class='kp-point-details'>";
    listView = listView + "<div class='row noselect'>";
    listView = listView + "<div class='kp-user-details'>";
    
    let profilepicPath = "";
    
    if (theKP.profilePicKey.length > 0)
    {
        profilepicPath = s3Path + profilePicFolder + theKP.profilePicKey + ".jpg";
        
    } else
    {
        profilepicPath = "img/user-default-img.png";
    }
    
    listView = listView + "<div id='kp-user-profilepic'><img src='" + profilepicPath + "' class='kp-user-profilepic noselect notap' onmousedown='return false' /></div>";
    listView = listView + "<div class='kp-username-col'>";
    listView = listView + "<div id='kp-username' class='kp-username''>" + theKP.creatorName + "</div>";
    
    if (theKP.pointClass === "P")
    {
        listView = listView + "<div id='kp-premium-tag' class='kp-premium-tag'>Premium</div>";
    }
    
    listView = listView + "</div>";
    listView = listView + "</div>";
    
    listView = listView + "<div class='kp-share-btn-single-list clickable' onclick='shareLink(\"" + theKP.pointLink + "\", false)'><img src='img/share-icon.png' class='noselect notap'></div>";
    
    if (theKP.topic.length > 0)
    {
        listView = listView + "<div id='kp-title-full' class='kp-title-full noselect notap'>" + theKP.topic + "</div>";
    }

    
    //start here
    listView = listView +  "<div class='place-details'>";

    if (theKP.price.length > 0)
    {
        listView = listView + "<div class='price'><div class='place-details-icon noselect notap'><img src='img/price-icon.png'/></div><div class='place-details-font'>" + theKP.price + "</div></div>";
    }
    
    listView = listView + "<div class='address'><div class='place-details-icon noselect notap'><img src='img/address-icon.png'/></div><div class='place-details-font'>" + theKP.address + "</div></div>";
    
    if (theKP.phone.length > 0)
    {
        listView = listView + "<div class='phone'><div class='place-details-icon noselect notap'><img src='img/phone-icon.png'/></div><div class='place-details-font'>" + theKP.phone + "</div></div>";
    }
    
    if (theKP.web.length > 0)
    {
        let theLink = theKP.web;
        
        if (theLink.substring(0, 4) !== "http")
        {
            theLink = "http://" + theLink;
        }
        
        listView = listView + "<div class='web'><div class='place-details-icon noselect notap'><img src='img/web-icon.png'/></div><div class='place-details-font'><a href='" + theLink + "' target='_blank'>" + theKP.web + "</a></div></div>";
    }
    
    if (theKP.hours.length > 0)
    {

        listView = listView + "<div class='hours'>";
        
        listView = listView + "<div class='place-details-icon noselect notap'><img src='img/hours-icon.png'/></div>";
        
        listView = listView + "<div class='place-details-font clickable' onclick='toggleHourDetails()'>";
        
        if (theKP.hours[dayOfWeek].length > 0)
        {
            theKP.hours[dayOfWeek].forEach(function (todayTime)
            {
                listView = listView + todayTime + " ";
            });
            
        } else
        {
            listView = listView + words["Closed"];
        }
        
        //hoursRow, hoursInfo 
        listView = listView + "(" + weekdayText[dayOfWeek] + ")</div></div>";
        
        listView = listView + "<div id='single-point-hour-details' class='hour-details place-details-font' style='display:none'><div class='time-day-col'><div class='hour-day'>" + weekdayText[0] + "</div><div class='hour-day'>" + weekdayText[1] + "</div><div class='hour-day'>" + weekdayText[2] + "</div><div class='hour-day'>" + weekdayText[3] + "</div><div class='hour-day'>" + weekdayText[4] + "</div><div class='hour-day'>" + weekdayText[5] + "</div><div class='hour-day'>" + weekdayText[6] + "</div></div><div class='time-hour-col'>";
        
        theKP.hours.forEach(function (aDay, idx)
        {
            listView = listView + "<div class='hour-el'>";
                            
            if (aDay.length > 0)
            {
                aDay.forEach(function (aTime)
                {
                    listView = listView + aTime + " ";
                });
                            
            } else
            {
                listView = listView + words["Closed"];
            }
            //do i need anything here?           
            listView = listView + "</div>";
        });
        
        //hour-details, time-hour-col
        listView = listView + "</div></div>";
    }
    
    listView = listView + "</div>";
    
    listView = listView + "</div>";
    listView = listView + "</div>";
    
    listView = listView + "</div>";
    listView = listView + "</div>";
    
    listView = listView + "<section id='klicks-section'>";
    
    theKP.theKlicks.forEach(function (aKlick) 
    {
                                        
        listView = listView + "<div class='klick-container-box noselect'>";
        
        var imgDimen = aKlick.imgDimen.split(":", 2);
        var imgHeight = (singlePointListWidthInt - (singleViewImgMarginInt * 2)) / imgDimen[0] * imgDimen[1];
                                            
        listView = listView + "<div class='klick-photo' style='height:" + imgHeight + "px;margin-left:"+singleViewImgMarginInt+"px;margin-right:"+singleViewImgMarginInt+"px;'><img src='"+ s3Path + imageFolder + aKlick.klickImgKey + ".jpg' class='noselect notap' onmousedown='return false' /></div>";
                            
        if (aKlick.caption.length > 0)
        {
            listView = listView + "<div class='klick-caption'>" + aKlick.caption + "</div>";
        }

        //append all div stuff here                   
        listView = listView + "</div>";
    });
    //append klickContainerBox hwere           
    listView = listView + "</section>";
    
    let savePointBtn = document.getElementById("save-point-btn");
    
    if (theKP.saved === "Y")
    {
        savePointBtn.classList.add("point-saved");
        savePointBtn.classList.remove("point-not-saved");
        
        savePointBtn.innerHTML = "<img src='img/bookmark-filled-icon.png' class='noselect notap'/>";
        
    } else
    {
        savePointBtn.classList.add("point-not-saved");
        savePointBtn.classList.remove("point-saved");
        
        savePointBtn.innerHTML = "<img src='img/bookmark-icon.png' class='noselect notap'/>";
    }
    
    let newSavePointBtn = savePointBtn.cloneNode(true);
    savePointBtn.parentNode.replaceChild(newSavePointBtn, savePointBtn);

    newSavePointBtn.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
                                                                    
        savePoint(newSavePointBtn, theKP.KPID, e);
                                                                                                                    
    });
                
    listView = listView + "</div>";
?>
?>
