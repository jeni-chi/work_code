 
<?php
    //Objective
    function showMapPointsOnMobile(theKPID, move, animated, changeMeta)
    {
        var listView = "";
        
        let theKP = pointStore[theKPID];
        
        selectedKPID = theKP.KPID;

        let kpContainerBox = document.createElement("div");
        kpContainerBox.id = "kp-container-box-small";
        kpContainerBox.className = "kp-container-box-small";

        if (theKP.mcActive === "Y")
        {

            let mcHeader = document.createElement("div");
            mcHeader.className = "mc-header";

            if (theKP.mcFree === "Y")
            {
                mcHeader.innerHTML = theKP.mcDiscount + "DiscountOrFree";

            } else
            {
                mcHeader.innerHTML = theKP.mcDiscount + "Discount";

            }

            kpContainerBox.appendChild(mcHeader);
            mobileTouchBarDash.style.opacity = 0;

        } else
        {
            mobileTouchBarDash.style.opacity = 1;
        }

        let kpBoxContent = document.createElement("div");
        kpBoxContent.className = "kp-container-box-content";

        let saveBtn = document.createElement("div");

        let saveBtnImg = document.createElement("img");
        saveBtnImg.className = "noselect notap";

        if (theKP.saved === "Y")
        {   
            saveBtn.className = "kp-save-mobile-btn point-saved clickable";
            saveBtn.setAttribute("onclick", "savePoint(this, " + theKP.KPID + ", event)");

            saveBtnImg.src = "img/bookmark-filled-icon.png";

        } else
        {
            saveBtn.className = "kp-save-mobile-btn point-not-saved clickable";
            saveBtn.setAttribute("onclick", "savePoint(this, " + theKP.KPID + ", event)");

            saveBtnImg.src = "img/bookmark-icon.png";
        }

        saveBtn.appendChild(saveBtnImg);


        let shareBtn = document.createElement("div");
        shareBtn.className = "kp-share-btn-small clickable";
        shareBtn.setAttribute("onclick", "shareLink(\"" + theKP.pointLink + "\", false)");

        let shareImg = document.createElement("img");
        shareImg.src = "img/share-icon.png";
        shareImg.className = "noselect notap";

        shareBtn.appendChild(shareImg);


        let kpPointDetails = document.createElement("div");
        kpPointDetails.className = "kp-point-details-small";

        let rowSection = document.createElement("div");
        rowSection.className = "row noselect";

        let kpUserDetails = document.createElement("div");
        kpUserDetails.className = "kp-user-details";


        let profilepicPath = "";


        if (theKP.profilePicKey.length > 0)
        {
            profilepicPath = s3Path + profilePicFolder + theKP.profilePicKey + ".jpg";
           
        } else
        {
            profilepicPath = "img/user-default-img.png";
        }


        let kpUserProfilePic = document.createElement("div");
        kpUserProfilePic.id = "kp-user-profilepic";

        let profilepicImg = document.createElement("img");
        profilepicImg.src = profilepicPath;
        profilepicImg.className = "kp-user-profilepic noselect notap";
        profilepicImg.setAttribute("onmousedown", "return false");

        let kpUsernameCol = document.createElement("div");
        kpUsernameCol.className = "kp-username-col";

        let kpUsername = document.createElement("div");
        kpUsername.id = "kp-username";
        kpUsername.className = "kp-username";


        let kpPremiumTag = document.createElement("div");

        if (theKP.pointClass === "P")
        {
            kpPremiumTag.id = "kp-premium-tag";
            kpPremiumTag.className = "kp-premium-tag";
            kpPremiumTag.innerHTML = theKP.topic;
        }

        kpUserDetails.appendChild(kpUserProfilePic);
        kpUserProfilePic.appendChild(profilepicImg);
        kpUserDetails.appendChild(kpUsernameCol);
        kpUsernameCol.appendChild(kpUsername);

        if (theKP.pointClass === "P")
        {
            kpUsernameCol.appendChild(kpPremiumTag);
        }
       
        rowSection.appendChild(kpUserDetails);


        if (theKP.topic.length > 0)
        {
            let topicTitle = document.createElement("div");
            topicTitle.id = "kp-title-small";
            topicTitle.className = "kp-title-small noselect";
            topicTitle.innerHTML = theKP.topic;
        }

        kpPointDetails.appendChild(rowSection);
        rowSection.appendChild(topicTitle);


        let thumbnail = document.createElement("div");

        let thumbnailImg = document.createElement("img");


        if (theKP.theKlicks.length > 1)
        {
            let scrollMenu = document.createElement("div");
            scrollMenu.id = "kp-scrollmenu-small";
            scrollMenu.className = "kp-scrollmenu-small";


            theKP.theKlicks.forEach(function (aKlick)
            {
                thumbnail.className = "kp-thumbnail-small";

                thumbnailImg.src = s3Path + thumbnailFolder + aKlick.klickImgKey + ".jpg";
                thumbnailImg.className = "noselect notap";
                thumbnailImg.setAttribute("onmousedown", "return false");

                thumbnail.appendChild(thumbnailImg);
            });

            scrollMenu.appendChild(thumbnail);

        } else
        {
            thumbnailImg.src = s3Path + imageFolder + theKP.theKlicks[0].klickImgKey + ".jpg";
            thumbnailImg.className = "noselect notap";
            thumbnailImg.setAttribute("onmousedown", "return false");
            thumbnail.appendChild(thumbnailImg);
        }
        
        kpBoxContent.appendChild(saveBtn);
        kpBoxContent.appendChild(shareBtn);
        kpBoxContent.appendChild(kpPointDetails);

        if (theKP.theKlicks.length > 1)
        {
            kpBoxContent.appendChild(scrollMenu);
        }

    
        kpContainerBox.appendChild(kpBoxContent);

        mobileMapPointContent.innerHTML = listView;

        listView = null;

        //set display to block to get mobileMapPointContent.clientHeight
        mobileMapPointContent.style.display = "block";
        
        listTopExistingY = contentWrapper.clientHeight - mobileMapPointContent.clientHeight;

        mobileSinglePointFrame.style.transition = "0.25s";
        mobileSinglePointFrame.style.top = listTopExistingY + "px";

        mobileSinglePointFrame.style.borderTopLeftRadius = "10px";
        mobileSinglePointFrame.style.borderTopRightRadius = "10px";

        listForMapPointVisible = true;
        
        if (pointListVisible)
        {
            pointListVisible = false;

            mobilePointListContent.style.opacity = 0;

            hideSingleListBtn.style.display = "none";
            bannerLogo.style.display = "table-cell";

        } else
        {
            if (toolBar.style.opacity > 0)
            {
                toolBar.style.opacity = 0;
            }
        }

        document.getElementById("kp-container-box-small").addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();
                                                                        
            showSingleList(theKPID, false, false, false);
                                                                       
        });

        if (move)
        {
            //Don't retrieve from server if the point is in the store
            if (pointStore[theKP.KPID])
            {
                reloadMap = false;
            }
            
            let latDiff = map.getBounds().getNorthWest().lat - map.getBounds().getSouthEast().lat;
            let adjustedLat = theKP.KPLat - (latDiff * 0.25);
                    
            if (animated)
            {
                map.flyTo({
                    center: [theKP.KPLng, adjustedLat],
                    essential: true,
                    speed: 1.5, // make the flying slow
                    curve: 1, // change the speed at which it zooms out
                    bearing: 0,

                    // This can be any easing function: it takes a number between
                    // 0 and 1 and returns another number between 0 and 1.
                    easing: function (t) {
                        return t;
                    }
                });
                
            } else
            {
                //Use current map zoom because adjustedLat is calculated based on that
                map.jumpTo({
                    center: [theKP.KPLng, adjustedLat],
                    zoom: map.getZoom(),
                    bearing: 0,
                });
            }
        }
                
        setTimeout(function()
        {
            mobileMapPointContent.style.opacity = 1;

            mobilePointListContent.style.display = "none";
            toolBar.style.display = "none";

            //When map doesn't reload
            //Update markers
            if (!move || pointStore[theKP.KPID])
            {
                markersOnMap.forEach(function (aMarker, markerKPID)
                {
                    let classList = aMarker.getElement().classList;
                                        
                    if (parseInt(markerKPID) === parseInt(selectedKPID))
                    {
                            if (classList.contains("marker-on-dir") === false)
                            {
                                classList.add("marker-on-dir");
                                classList.remove("marker-on");
                                classList.remove("marker");
                                classList.remove("marker-off");
                            }
                            
                    } else
                    {
                            if (classList.contains("marker-off") === false)
                            {
                                classList.add("marker-off");
                                classList.remove("marker-on-dir");
                                classList.remove("marker-on");
                                classList.remove("marker");
                            }
                    }
                                        
                });
            }

        }, 250);

        if (changeMeta)
        {
            changeMetaSettingsForKP(theKP);
        }
    }

    function refreshControlList(appendSearchOnly, transition, moveToTop)
    {
        let showFocusGroup = false;
        
        let listContent = "";
        
        if (userID > 0)
        {
            if (theFocusLinkGroup)
            {
                showFocusGroup = true;
            }
            
        } else
        {
            if (searchBar.value.trim().length === 0)
            {
                if (theFocusLinkGroup)
                {
                    showFocusGroup = true;
                }
            }
        }
        
        if (transition)
        {
            controlListContent.style.opacity = "0";
        }
        
        let theGroupIDs = [];
        let theOtherGroupIDs = [];
        
        if (showFocusGroup)
        {
            let groupBox = document.createElement("div");
            groupBox.className = "group-box-large noselect";
            groupBox.setAttribute("onclick", "moveToGroupLoc(event, \"" + theFocusLinkGroup.groupID + "\", false)");

            let groupInfo = document.createElement("div");
            groupInfo.className = "group-info noselect";

            let groupImgPath = "";

            if (theFocusLinkGroup.groupImgKey.length > 0)
            {
                groupImgPath = s3Path + groupImageFolder + theFocusLinkGroup.groupImgKey + ".jpg";
              
            } else
            {
                groupImgPath = "img/group-default-img.png";
            }

            let groupImgBorderOn = "";

            if (theFocusLinkGroup.groupType === "O" || theFocusLinkGroup.groupRole === "C" || theFocusLinkGroup.groupRole === "A" || theFocusLinkGroup.groupRole === "M")
            {
                if (selectedGroups.indexOf(theFocusLinkGroup.groupID.toString()) > -1)
                {
                    groupImgBorderOn = "group-pic-border-on";
                } 
            }
                  
            let groupChannel = document.createElement("div");
            groupChannel.className = "channel-group-pic-large " + groupImgBorderOn + " noselect";

            let groupImg = document.createElement("img");
            groupImg.src = groupImgPath;
            groupImg.className - "noselect notap";
            
            groupChannel.appendChild(groupImg);

            let groupTypeIcon = document.createElement("img");
            groupTypeIcon.src = "img/channel-o-icon.png";
            groupTypeIcon.className = "group-type-icon";

            if (theFocusLinkGroup.groupType === "R")
            {
                groupTypeIcon.src = "img/channel-r-icon.png";
                
            } else if (theFocusLinkGroup.groupType === "C")
            {
                groupTypeIcon.src = "img/channel-c-icon.png";

            }
            
            let groupName = document.createElement("div");
            groupName.className = "group-name-large noselect notap";
            groupName.innerHTML = theFocusLinkGroup.groupName;

            let groupStats = document.createElement("div");
            groupStats.className = "group-stat noselect notap";
            groupStats.innerHTML = theFocusLinkGroup.noOfKPs + " " + "Points" + " • " + theFocusLinkGroup.noOfMembers + " " + "Followers" + groupTypeIcon;

            let premiumTag = document.createElement("div");

            let groupDesc = document.createElement("div");

            if (theFocusLinkGroup.premium === "Y")
            {
                premiumTag.className = "group-premium-tag-large noselect notap";
                premiumTag.innerHTML = "PremiumAvail";

            } else
            {
                premiumTag.style.display = "none";
            }

            if (theFocusLinkGroup.groupDesc.length > 0)
            {
                groupDesc.className = "group-mission noselect notap";
                groupDesc.innerHTML = theFocusLinkGroup.groupDesc;

            } else
            {
                groupDesc.style.display = "none";
            }


            groupBox.appendChild(groupInfo);
            groupInfo.appendChild(groupChannel);
            groupInfo.appendChild(groupName);
            groupInfo.appendChild(groupStats);
            groupInfo.appendChild(premiumTag);
            groupInfo.appendChild(groupDesc);


            let groupLink = document.createElement("div");
            groupLink.className = "group-share-large-btn clickable noselect";
            groupLink.setAttribute("onclick", "shareLink(\"" + theFocusLinkGroup.link + "\", true)");

            let groupLinkImg = document.createElement("img");
            groupLinkImg.src = "img/share-icon.png";
            groupLinkImg.className = "noselect notap";

            groupLink.appendChild(groupLinkImg);

            let groupFollow = document.createElement("div");

            if (userID > 0)
            {
                groupFollow.id = "follow-group-btn";
                groupFollow.setAttribute("onclick", "followGroup(this, " + theFocusLinkGroup.groupID + ", event)");


                if (theFocusLinkGroup.groupRole === "C" || theFocusLinkGroup.groupRole === "A")
                {
                
                } else if (theFocusLinkGroup.groupRole === "M")
                {
                    groupFollow.className = "group-function-large-btn button-light-inverse clickable noselect";
                    groupFollow.innerHTML = "Following";

                } else if (theFocusLinkGroup.groupRole === "R")
                {
                    groupFollow.className = "group-function-large-btn button-gray clickable noselect";
                    groupFollow.innerHTML = "Requested";

                } else 
                {
                    groupFollow.className = "group-function-large-btn button-light clickable noselect";
                    groupFollow.innerHTML = "Follow";
                }

            } else
            {
                groupFollow.className = "group-function-large-btn button-light clickable noselect";
                groupFollow.setAttribute("onclick", "showLoginEvent(event)");
                groupFollow.innerHTML = "Follow";

            }

            exitFocusChannelBtn.style.display = "block";
            controlListContent.style.paddingBottom = exitFocusChannelBtn.clientHeight + "px";

            groupBox.appendChild(groupFollow);
         
        } else
        {
            if (!appendSearchOnly)
            {
                let groups = userGroups;
                
                if (searchBar.value.trim().length > 0)
                {
                    groups = followingSearchGroups;
                }
                
                if (userID > 0)
                {
                    //Arrange orders here
                    var theGroups = [];
                    
                    groups.forEach(function (theGroup) {
                    
                        var idx = selectedGroups.indexOf(theGroup.groupID.toString());

                        if (idx > -1)
                        {
                            //Put selected group at the top
                            theGroups.unshift(theGroup);
                                   
                        } else
                        {
                            theGroups.push(theGroup);
                        }
                    });
                    
                    if (searchTerm.length === 0 || theGroups.length > 0)
                    {
                        let groupList = document.createElement("div");
                        groupList.className = "group-list-separator noselect notap";
                        groupList.innerHTML = "MyFollowing";
                        
                        if (searchTerm.length === 0)
                        {
                            groupCollect = document.createElement("div");
                            groupCollect.id = "group_cell0";
                            groupCollect.setAttribute("onclick", "selectGroup(\"0\")");

                            //GroupID 0 is for show the user's collection
                            if (selectedGroups[0] === "0")
                            {
                                groupCollect.className = "group-box group-box-selected noselect clickable";
                               
                            } else
                            {
                                groupCollect.className = "group-box noselect clickable";

                            }

                            let groupBMark = document.createElement("div");
                            groupBMark.className = "bookmark-pic";

                            let groupBMarkImg = document.createElement("img");
                            groupBMarkImg.src = "img/bookmark-filled-icon.png";
                            groupBMarkImg.className = "noselect notap";
                            groupBMarkImg.setAttribute("onmousedown", "return false");

                            groupBMark.appendChild(groupBMarkImg);

                            let groupCollectTitle = document.createElement("div");
                            groupCollectTitle.className = "group-name noselect notap";
                            groupCollectTitle.innerHTML = "MyCollections";

                            groupBox.appendChild(groupList);
                            groupBox.appendChild(groupCollect);
                            groupCollect.appendChild(groupBMark);
                            groupCollect.appendChild(groupCollectTitle);

                            theGroupIDs.push(0);
                        } 
                    }
                    
                    theGroups.forEach(function (theGroup) {

                        var idx = selectedGroups.indexOf(theGroup.groupID.toString());

                        let groupCell = document.createElement("div");
                        groupCell.id = "group_cell" + theGroup.groupId;
                        groupCell.setAttribute("onclick", "selectGroup(\"" + theGroup.groupID + "\")");
                        
                        if (idx > -1)
                        {
                            groupCell.className = "group-box group-box-selected noselect clickable";
                          
                        } else 
                        {
                            groupCell.className = "group-box noselect clickable";
      
                        }

                        let groupImgPath = "";

                        if (theGroup.groupImgKey.length > 0)
                        {
                            groupImgPath = s3Path + groupImageFolder + theGroup.groupImgKey + ".jpg";
                           
                        } else
                        {
                            groupImgPath = "img/group-default-img.png";
                        }

                        let groupID = document.createElement("div");
                        groupID.className = "noselect";
                        groupID.setAttribute("onclick", "setFocusGroup(event, \"" + theGroup.groupID + "\")");

                        let groupID_Img = document.createElement("img");
                        groupID_Img.src = groupImgPath;
                        groupID_Img.className = "group-pic noselect notap";
                        groupID_Img.setAttribute("onmousedown", "return false");

                        groupID.appendChild(groupID_Img);

                        let groupID_Name = document.createElement("div");
                        groupID_Name.className = "group-name noselect notap";
                        groupID_Name.innerHTML = theGroup.groupName;

                        let groupBtn = document.createElement("div");
                        groupBtn.className = "group-loc-btn noselect";

                        let groupBtnImg = document.createElement("img");
                        groupBtnImg.src = "img/location.png";
                        groupBtnImg.className = "noselect notap";

                        if (parseFloat(theGroup.groupLng) != 0.0 || parseFloat(theGroup.groupLat) != 0.0)
                        {
                            groupBtn.setAttribute("onclick", "moveToGroupLoc(event, \"" + theGroup.groupID + "\", true)");

                        } else 
                        {
                            groupBtnImg.style.opacity = 0.35;
                        }

                        groupBtn.appendChild(groupBtnImg);
                        groupBox.appendChild(groupCell);
                        groupCell.appendChild(groupID);
                        groupCell.appendChild(groupID_Name);
                        groupCell.appendChild(groupBtn);

                        theGroupIDs.push(theGroup.groupID);

                    });
                }
            }

            if (otherSearchGroups.length > 0 && (!appendSearchOnly || document.getElementById("group-list-separator") === null))
            {

                let groupList_Sep = document.createElement("div");
                groupList_Sep.id = "group-list-separator";
                groupList_Sep.className = "group-list-separator noselect notap";

                if (searchBar.value.trim().length === 0)
                {
                    groupList_Sep.innerHTML = "ChSuggestion";

                } else
                {
                    groupList_Sep.innerHTML = "SearchResults";

                }

                otherSearchGroups.forEach(function (theGroup) {

                    let groupBox = document.createElement("div");
                    groupBox.className = "group-box-large noselect";
                    groupBox.setAttribute("onclick", "moveToGroupLoc(event, \"" + theGroup.groupID + "\", false)");

                    let groupInfo = document.createElement("div");
                    groupInfo.className = "group-info noselect";

                    let groupImgPath = "";

                    if (theGroup.groupImgKey.length > 0)
                    {
                        groupImgPath = s3Path + groupImageFolder + theGroup.groupImgKey + ".jpg";
                     
                    } else
                    {
                        groupImgPath = "img/group-default-img.png";
                    }

                    let groupImgBorderOn = "";

                    if (theGroup.groupType === "O" || theGroup.groupRole === "C" || theGroup.groupRole === "A" || theGroup.groupRole === "M")
                    {
                        if (selectedGroups.indexOf(theGroup.groupID.toString()) > -1)
                        {
                            groupImgBorderOn = "group-pic-border-on";
                        } 
                    }

                    let groupChannel = document.createElement("div");
                    groupChannel.className = "channel-group-pic-large " + groupImgBorderOn + " noselect";

                    let groupImg = document.createElement("img");
                    groupImg.src = "groupImgPath";
                    groupImg.className = "noselect notap";

                    groupChannel.appendChild(groupImg);

                    let groupTypeIcon = document.createELement("img");
                    groupTypeIcon.src = "img/channel-o-icon.png";
                    groupTypeIcon.className = "group-type-icon";
                    
                    if (theGroup.groupType === "R")
                    {
                        groupTypeIcon.src = "img/channel-r-icon.png";

                    } else if (theGroup.groupType === "C")
                    {
                        groupTypeIcon.src = "img/channel-c-icon.png";
                    }

                    let groupName = document.createElement("div");
                    groupName.className = "group-name-large noselect notap";
                    groupName.innerHTML = theGroup.groupName;

                    let groupStats = document.createElement("div");
                    groupStats.className = "group-stat noselect notap";
                    groupStats.innerHTML = theGroup.noOfKPs + " " + "Points" + " • " + theGroup.noOfMembers + " " +  "Followers" + groupTypeIcon;

                    let premiumTag = document.createElement("div");

                    let groupDesc = document.createElement("div");

                    if (theGroup.premium === "Y")
                    {
                        premiumTag.className ="group-premium-tag-large noselect notap";
                        premiumTag.innerHTML = "PremiumAvail";
                    } else
                    {
                        premiumTag.style.display = "none";
                    }
                          
                   if (theGroup.groupDesc.length > 0)
                   {
                        groupDesc.className ="group-mission noselect notap";
                        groupDesc.innerHTML = theGroup.groupDesc;
                   } else
                   {
                        groupDesc.style.display = "none";
                   }

                   groupBox.appendChild(groupInfo);
                   groupInfo.appendChild(groupChannel);
                   groupInfo.appendChild(groupName);
                   groupInfo.appendChild(groupStats);
                   groupInfo.appendChild(premiumTag);
                   groupInfo.appendChild(groupDesc);

                   let groupLink = document.createElement("div");
                   groupLink.className = "group-share-large-btn clickable noselect";
                   groupLink.setAttribute("onclick", "shareLink(\"" + theFocusLinkGroup.link + "\", true)");

                   let groupLinkImg = document.createElement("img");
                   groupLinkImg.src = "img/share-icon.png";
                   groupLinkImg.className = "noselect notap";

                   groupLink.appendChild(groupLinkImg);

                   let groupFollow = document.createElement("div");
                   groupFollow.id = "follow-group-btn" + theGroup.groupID;

                   if (userID > 0)
                   {
                    groupFollow.setAttribute("onclick", "followGroup(this, " + theGroup.groupID + ", event)");

                    if (theGroup.groupRole === "C" || theGroup.groupRole === "A")
                    {
                        
                    } else if (theGroup.groupRole === "M")
                    {
                        groupFollow.className = "group-function-large-btn button-light-inverse clickable noselect";
                        groupFollow.innerHTML = "Following";

                    } else if (heGroup.groupRole === "R")
                    {
                        groupFollow.className = "group-function-large-btn button-gray clickable noselect";
                        groupFollow.innerHTML = "Requested";

                    } else
                    {
                        groupFollow.className = "group-function-large-btn button-light clickable noselect";
                        groupFollow.innerHTML = "Follow";
                    }

                   } else
                   {
                        groupFollow.className = "group-function-large-btn button-light clickable noselect";
                        groupFollow.setAttribute("onclick", "showLoginEvent(event)");
                        groupFollow.innerHTML = "Follow";
                   }

                   let groupSep = document.createELement("div");
                   groupSep.className = "group-box-large-separator noselect notap";

                   groupBox.appendChild(groupLink);
                   groupBox.appendChild(groupFollow);
                   groupBox.appendChild(groupSep);

                   theOtherGroupIDs.push(theGroup.groupID);
                });

            }   
        }


        let updateTime = 0;
        
        if (transition)
        {
            updateTime = 300;
        }
        
        setTimeout(function()
        {
            if (showFocusGroup)
            {
                controlListContent.innerHTML = listContent;
                   
            } else
            {
               if (!appendSearchOnly)
               {
                    controlListContent.innerHTML = listContent;
               
                   if (userID > 0)
                   {
                        groupCells.length = 0;
                  
                        theGroupIDs.forEach(function (theGroupID)
                        {
                            groupCells[theGroupID] = document.getElementById("group_cell" + theGroupID);
                        });
                   }
                   
               } else
               {
                   if (otherSearchGroups.length > 0 && document.getElementById("group-list-separator") === null)
                   {
                        controlListContent.insertAdjacentHTML("beforeend", listContent);
                   }
               }
            }
                   
            controlListContent.style.opacity = "1";
                   
            if (moveToTop)
            {
                controlListContent.scrollTop = 0;
            }
                   
        }, updateTime);

    }

    //Final Code
    function showMapPointsOnMobile(theKPID, move, animated, changeMeta)
    {
        let theKP = pointStore[theKPID];
        
        selectedKPID = theKP.KPID;

        let kpContainerBox = document.createElement("div");
        kpContainerBox.id = "kp-container-box-small";
        kpContainerBox.className = "kp-container-box-small";
        kpContainerBox.setAttribute("onclick", "showSingleList(" + theKPID + ", false, false, false)");

        if (theKP.mcActive === "Y")
        {
            let mcHeader = document.createElement("div");
            mcHeader.className = "mc-header";

            if (theKP.mcFree === "Y")
            {
                mcHeader.innerHTML = theKP.mcDiscount + words["DiscountOrFree"];

            } else
            {
                mcHeader.innerHTML = theKP.mcDiscount + words["Discount"];
            }

            kpContainerBox.appendChild(mcHeader);

            mobileTouchBarDash.style.opacity = 0;

        } else
        {
            mobileTouchBarDash.style.opacity = 1;
        }

        let kpBoxContent = document.createElement("div");
        kpBoxContent.className = "kp-container-box-content";

        let saveBtn = document.createElement("div");
        saveBtn.setAttribute("onclick", "savePoint(this, " + theKP.KPID + ", event)");

        let saveBtnImg = document.createElement("img");
        saveBtnImg.className = "noselect notap";

        if (theKP.saved === "Y")
        {   
            saveBtn.className = "kp-save-mobile-btn point-saved clickable";
            saveBtnImg.src = "img/bookmark-filled-icon.png";

        } else
        {
            saveBtn.className = "kp-save-mobile-btn point-not-saved clickable";
            saveBtnImg.src = "img/bookmark-icon.png";
        }

        saveBtn.appendChild(saveBtnImg);


        let shareBtn = document.createElement("div");
        shareBtn.className = "kp-share-btn-small clickable";
        shareBtn.setAttribute("onclick", "shareLink(\"" + theKP.pointLink + "\", false)");

        let shareImg = document.createElement("img");
        shareImg.src = "img/share-icon.png";
        shareImg.className = "noselect notap";

        shareBtn.appendChild(shareImg);

        let kpPointDetails = document.createElement("div");
        kpPointDetails.className = "kp-point-details-small";

        let rowSection = document.createElement("div");
        rowSection.className = "row noselect";

        let kpUserDetails = document.createElement("div");
        kpUserDetails.className = "kp-user-details";


        let profilepicPath = "";


        if (theKP.profilePicKey.length > 0)
        {
            profilepicPath = s3Path + profilePicFolder + theKP.profilePicKey + ".jpg";
           
        } else
        {
            profilepicPath = "img/user-default-img.png";
        }

        let kpUserProfilePic = document.createElement("div");
        kpUserProfilePic.id = "kp-user-profilepic";

        let profilepicImg = document.createElement("img");
        profilepicImg.src = profilepicPath;
        profilepicImg.className = "kp-user-profilepic noselect notap";
        profilepicImg.setAttribute("onmousedown", "return false");

        let kpUsernameCol = document.createElement("div");
        kpUsernameCol.className = "kp-username-col";

        let kpUsername = document.createElement("div");
        kpUsername.id = "kp-username";
        kpUsername.className = "kp-username";
        kpUsername.innerHTML = theKP.creatorName;

        let kpPremiumTag = document.createElement("div");

        if (theKP.pointClass === "P")
        {
            kpPremiumTag.id = "kp-premium-tag";
            kpPremiumTag.className = "kp-premium-tag";
            kpPremiumTag.innerHTML = words["Premium"];
        }

        kpUserDetails.appendChild(kpUserProfilePic);
        kpUserProfilePic.appendChild(profilepicImg);
        kpUserDetails.appendChild(kpUsernameCol);
        kpUsernameCol.appendChild(kpUsername);

        if (theKP.pointClass === "P")
        {
            kpUsernameCol.appendChild(kpPremiumTag);
        }
       
        rowSection.appendChild(kpUserDetails);

        let topicTitle = document.createElement("div");

        if (theKP.topic.length > 0)
        {
            topicTitle.id = "kp-title-small";
            topicTitle.className = "kp-title-small noselect";
            topicTitle.innerHTML = theKP.topic;

        } else
        {
            topicTitle.style.display = "none";
        }

        kpPointDetails.appendChild(rowSection);
        rowSection.appendChild(topicTitle);

        let scrollMenu = document.createElement("div");
        scrollMenu.id = "kp-scrollmenu-small";
        scrollMenu.className = "kp-scrollmenu-small";

        let singleThumbnail = document.createElement("div");
        singleThumbnail.className = "kp-thumbnail-single-small";

        if (theKP.theKlicks.length > 1)
        {
            theKP.theKlicks.forEach(function (aKlick)
            {
                let thumbnail = document.createElement("div");
                thumbnail.className = "kp-thumbnail-small";

                let thumbnailImg = document.createElement("img");
                thumbnailImg.src = s3Path + thumbnailFolder + aKlick.klickImgKey + ".jpg";
                thumbnailImg.className = "noselect notap";
                thumbnailImg.setAttribute("onmousedown", "return false");

                scrollMenu.appendChild(thumbnail);
                thumbnail.appendChild(thumbnailImg);
            });

        } else
        {
            let thumbnailImg = document.createElement("img");
            thumbnailImg.src = s3Path + imageFolder + theKP.theKlicks[0].klickImgKey + ".jpg";
            thumbnailImg.className = "noselect notap";
            thumbnailImg.setAttribute("onmousedown", "return false");

            scrollMenu.appendChild(singleThumbnail);
            singleThumbnail.appendChild(thumbnailImg);
        }
        
        kpBoxContent.appendChild(saveBtn);
        kpBoxContent.appendChild(shareBtn);
        kpBoxContent.appendChild(kpPointDetails);

        if (theKP.theKlicks.length > 1)
        {
            kpBoxContent.appendChild(scrollMenu);

        } else
        {
            kpBoxContent.appendChild(singleThumbnail);
        }
           
        kpContainerBox.appendChild(kpBoxContent);

        mobileMapPointContent.replaceChildren();
        mobileMapPointContent.appendChild(kpContainerBox);

        listForMapPointVisible = true;
        
        let delayTime = 0;

        if (pointListVisible)
        {
            pointListVisible = false;

            mobilePointListContent.style.opacity = 0;

            hideSingleListBtn.style.display = "none";
            bannerLogo.style.display = "table-cell";

            delayTime = 150;

        } else
        {
            if (toolBar.style.opacity > 0)
            {
                toolBar.style.opacity = 0;
            }
        }

        //set display to block to get mobileMapPointContent.clientHeight
        mobileMapPointContent.style.display = "block";

        if (move)
        {
            //Don't retrieve from server if the point is in the store
            if (pointStore[theKP.KPID])
            {
                reloadMap = false;
            }
            
            let latDiff = map.getBounds().getNorthWest().lat - map.getBounds().getSouthEast().lat;
            let adjustedLat = theKP.KPLat - (latDiff * 0.25);
                    
            if (animated)
            {
                map.flyTo({
                    center: [theKP.KPLng, adjustedLat],
                    essential: true,
                    speed: 1.5, // make the flying slow
                    curve: 1, // change the speed at which it zooms out
                    bearing: 0,

                    // This can be any easing function: it takes a number between
                    // 0 and 1 and returns another number between 0 and 1.
                    easing: function (t) {
                        return t;
                    }
                });
                
            } else
            {
                //Use current map zoom because adjustedLat is calculated based on that
                map.jumpTo({
                    center: [theKP.KPLng, adjustedLat],
                    zoom: map.getZoom(),
                    bearing: 0,
                });
            }
        }
                
        setTimeout(function()
        {
            listTopExistingY = contentWrapper.clientHeight - mobileMapPointContent.clientHeight;

            mobileSinglePointFrame.style.transition = "0.25s";
            mobileSinglePointFrame.style.top = listTopExistingY + "px";

            mobileSinglePointFrame.style.borderTopLeftRadius = "10px";
            mobileSinglePointFrame.style.borderTopRightRadius = "10px";

            mobileMapPointContent.style.opacity = 1;

            mobilePointListContent.style.display = "none";
            toolBar.style.display = "none";

            //When map doesn't reload
            //Update markers
            if (!move || pointStore[theKP.KPID])
            {
                selectMarkerOnMap(selectedKPID);
            }

        }, delayTime);

        if (changeMeta)
        {
            changeMetaSettingsForKP(theKP);
        }
    }

    function refreshControlList(appendSearchOnly, transition, moveToTop)
    {

        let showFocusGroup = false;
        
        if (userID > 0)
        {
            if (theFocusLinkGroup)
            {
                showFocusGroup = true;
            }
            
        } else
        {
            if (searchBar.value.trim().length === 0)
            {
                if (theFocusLinkGroup)
                {
                    showFocusGroup = true;
                }
            }
        }
        
        let updateTime = 0;

        if (transition)
        {
            controlListContent.style.opacity = "0";
            updateTime = 250;
        }

        let mainNode;

        if (showFocusGroup || !appendSearchOnly)
        {
            mainNode = document.createElement("div");
            
        } else
        {
            if (controlListContent.hasChildNodes())
            {
                mainNode = controlListContent.childNodes[0];

            } else
            {
                mainNode = document.createElement("div");
            }
        }

        setTimeout(function()
        {
            let theGroupIDs = [];
        
            if (showFocusGroup)
            {
                appendGroupDetailsCellOnEl(theFocusLinkGroup, mainNode, false);

                exitFocusChannelBtn.style.display = "block";
                controlListContent.style.paddingBottom = exitFocusChannelBtn.clientHeight + "px";
            
            } else
            {
                if (!appendSearchOnly)
                {
                    let groups = userGroups;
                    
                    if (searchBar.value.trim().length > 0)
                    {
                        groups = followingSearchGroups;
                    }
                    
                    if (userID > 0)
                    {
                        //Arrange orders here
                        var theGroups = [];
                        
                        groups.forEach(function (theGroup) {
                        
                            var idx = selectedGroups.indexOf(theGroup.groupID.toString());

                            if (idx > -1)
                            {
                                //Put selected group at the top
                                theGroups.unshift(theGroup);
                                    
                            } else
                            {
                                theGroups.push(theGroup);
                            }
                        });
                        
                        if (searchTerm.length === 0 || theGroups.length > 0)
                        {
                            let groupListSeparator = document.createElement("div");
                            groupListSeparator.className = "group-list-separator noselect notap";
                            groupListSeparator.innerHTML = words["MyFollowing"];
                            
                            mainNode.appendChild(groupListSeparator);

                            if (searchTerm.length === 0)
                            {
                                let groupCell = document.createElement("div");
                                groupCell.id = "group_cell0";
                                groupCell.setAttribute("onclick", "selectGroup(\"0\")");

                                //GroupID 0 is for show the user's collection
                                if (selectedGroups[0] === "0")
                                {
                                    groupCell.className = "group-box group-box-selected noselect clickable";
                                
                                } else
                                {
                                    groupCell.className = "group-box noselect clickable";

                                }

                                let groupBMark = document.createElement("div");
                                groupBMark.className = "bookmark-pic";

                                let groupBMarkImg = document.createElement("img");
                                groupBMarkImg.src = "img/bookmark-filled-icon.png";
                                groupBMarkImg.className = "noselect notap";
                                groupBMarkImg.setAttribute("onmousedown", "return false");

                                let groupNameLabel = document.createElement("div");
                                groupNameLabel.className = "group-name noselect notap";
                                groupNameLabel.innerHTML = words["MyCollections"];

                                groupCell.appendChild(groupBMark);
                                groupBMark.appendChild(groupBMarkImg);
                                groupCell.appendChild(groupNameLabel);

                                mainNode.appendChild(groupCell);

                                theGroupIDs.push(0);
                            } 
                        }
                        
                        theGroups.forEach(function (theGroup) {

                            var idx = selectedGroups.indexOf(theGroup.groupID.toString());

                            let groupCell = document.createElement("div");
                            groupCell.id = "group_cell" + theGroup.groupID;
                            groupCell.setAttribute("onclick", "selectGroup(\"" + theGroup.groupID + "\")");
                            
                            if (idx > -1)
                            {
                                groupCell.className = "group-box group-box-selected noselect clickable";
                            
                            } else 
                            {
                                groupCell.className = "group-box noselect clickable";
                            }

                            let groupImgPath = "";

                            if (theGroup.groupImgKey.length > 0)
                            {
                                groupImgPath = s3Path + groupImageFolder + theGroup.groupImgKey + ".jpg";
                            
                            } else
                            {
                                groupImgPath = "img/group-default-img.png";
                            }

                            let groupImgWrapper = document.createElement("div");
                            groupImgWrapper.className = "noselect";
                            groupImgWrapper.setAttribute("onclick", "setFocusGroup(event, \"" + theGroup.groupID + "\")");

                            let groupImg = document.createElement("img");
                            groupImg.src = groupImgPath;
                            groupImg.className = "group-pic noselect notap";
                            groupImg.setAttribute("onmousedown", "return false");

                            let groupNameLabel = document.createElement("div");
                            groupNameLabel.className = "group-name noselect notap";
                            groupNameLabel.innerHTML = theGroup.groupName;

                            let locBtn = document.createElement("div");
                            locBtn.className = "group-loc-btn noselect";

                            let locBtnImg = document.createElement("img");
                            locBtnImg.src = "img/location.png";
                            locBtnImg.className = "noselect notap";

                            if (parseFloat(theGroup.groupLng) != 0.0 || parseFloat(theGroup.groupLat) != 0.0)
                            {
                                locBtn.setAttribute("onclick", "moveToGroupLoc(event, \"" + theGroup.groupID + "\", true)");

                            } else 
                            {
                                locBtnImg.style.opacity = 0.35;
                            }

                            groupCell.appendChild(groupImgWrapper);
                            groupImgWrapper.appendChild(groupImg);
                            groupCell.appendChild(groupNameLabel);
                            groupCell.appendChild(locBtn);
                            locBtn.appendChild(locBtnImg);

                            mainNode.appendChild(groupCell);

                            theGroupIDs.push(theGroup.groupID);

                        });
                    }
                }

                if (otherSearchGroups.length > 0 && (!appendSearchOnly || document.getElementById("group-list-separator") === null))
                {
                    let groupListSeparator = document.createElement("div");
                    groupListSeparator.id = "group-list-separator";
                    groupListSeparator.className = "group-list-separator noselect notap";

                    if (searchBar.value.trim().length === 0)
                    {
                        groupListSeparator.innerHTML = words["ChSuggestion"];

                    } else
                    {
                        groupListSeparator.innerHTML = words["SearchResults"];

                    }

                    mainNode.appendChild(groupListSeparator);

                    otherSearchGroups.forEach(function (otherGroup) {

                        appendGroupDetailsCellOnEl(otherGroup, mainNode, true);

                    });
                }   
            }

            if (showFocusGroup || !appendSearchOnly)
            {
                if (controlListContent.hasChildNodes())
                {
                    controlListContent.replaceChild(mainNode, controlListContent.childNodes[0]);

                } else
                {
                    controlListContent.appendChild(mainNode);
                }
            }

            
            if (!showFocusGroup && !appendSearchOnly && userID > 0)
            {
                groupCells.length = 0;
            
                theGroupIDs.forEach(function (theGroupID)
                {
                    groupCells[theGroupID] = document.getElementById("group_cell" + theGroupID);
                });
            }
                   
            controlListContent.style.opacity = "1";
                   
            if (moveToTop)
            {
                controlListContent.scrollTop = 0;
            }
                   
        }, updateTime);
    }

    function appendGroupDetailsCellOnEl(theGroup, theEl, addGroupSeparator)
    {
        let groupBox = document.createElement("div");
        groupBox.className = "group-box-large noselect";
        groupBox.setAttribute("onclick", "groupDetailBoxTap(event, \"" + theGroup.groupID + "\", false)");

        let groupInfo = document.createElement("div");
        groupInfo.className = "group-info noselect";

        let groupImgPath = "";

        if (theGroup.groupImgKey.length > 0)
        {
            groupImgPath = s3Path + groupImageFolder + theGroup.groupImgKey + ".jpg";
            
        } else
        {
            groupImgPath = "img/group-default-img.png";
        }

        let groupImgBorderOn = "";

        if (theGroup.groupType === "O" || theGroup.groupRole === "C" || theGroup.groupRole === "A" || theGroup.groupRole === "M")
        {
            if (selectedGroups.indexOf(theGroup.groupID.toString()) > -1)
            {
                groupImgBorderOn = "group-pic-border-on";
            } 
        }

        let groupImgWrapper = document.createElement("div");
        groupImgWrapper.className = "channel-group-pic-large " + groupImgBorderOn + " noselect";

        let groupImg = document.createElement("img");
        groupImg.src = groupImgPath;
        groupImg.className = "noselect notap";

        let groupTypeIcon = document.createElement("img");
        groupTypeIcon.className = "group-type-icon";
        groupTypeIcon.src = "img/channel-o-icon.png";
        
        if (theGroup.groupType === "R")
        {
            groupTypeIcon.src = "img/channel-r-icon.png";

        } else if (theGroup.groupType === "C")
        {
            groupTypeIcon.src = "img/channel-c-icon.png";
        }

        let groupNameLabel = document.createElement("div");
        groupNameLabel.className = "group-name-large noselect notap";
        groupNameLabel.innerHTML = theGroup.groupName;

        let groupStats = document.createElement("div");
        groupStats.className = "group-stat noselect notap";
        groupStats.innerHTML = theGroup.noOfKPs + " " + words["Points"] + " • " + theGroup.noOfMembers + " " +  words["Followers"];

        let premiumTag = document.createElement("div");

        if (theGroup.premium === "Y")
        {
            premiumTag.className = "group-premium-tag-large noselect notap";
            premiumTag.innerHTML = words["PremiumAvail"];

        } else
        {
            premiumTag.style.display = "none";
        }

        let groupDescLabel = document.createElement("div");
                
        if (theGroup.groupDesc.length > 0)
        {
            groupDescLabel.className ="group-mission noselect notap";
            groupDescLabel.innerHTML = theGroup.groupDesc;

        } else
        {
            groupDescLabel.style.display = "none";
        }

        
        let groupLinkBtn = document.createElement("div");
        groupLinkBtn.className = "group-share-large-btn clickable noselect";
        groupLinkBtn.setAttribute("onclick", "shareLink(\"" + theGroup.link + "\", true)");

        let groupLinkImg = document.createElement("img");
        groupLinkImg.src = "img/share-icon.png";
        groupLinkImg.className = "noselect notap";

        let groupFollowBtn = document.createElement("div");
        groupFollowBtn.id = "follow-group-btn" + theGroup.groupID;

        if (userID > 0)
        {
            groupFollowBtn.setAttribute("onclick", "followGroup(this, " + theGroup.groupID + ", event)");

            if (theGroup.groupRole === "C" || theGroup.groupRole === "A")
            {
                
            } else if (theGroup.groupRole === "M")
            {
                groupFollowBtn.className = "group-function-large-btn button-light-inverse clickable noselect";
                groupFollowBtn.innerHTML = words["Following"];

            } else if (theGroup.groupRole === "R")
            {
                groupFollowBtn.className = "group-function-large-btn button-gray clickable noselect";
                groupFollowBtn.innerHTML = words["Requested"];

            } else
            {
                groupFollowBtn.className = "group-function-large-btn button-light clickable noselect";
                groupFollowBtn.innerHTML = words["Follow"];
            }

        } else
        {
            groupFollowBtn.className = "group-function-large-btn button-light clickable noselect";
            groupFollowBtn.setAttribute("onclick", "showLoginEvent(event)");
            groupFollowBtn.innerHTML = words["Follow"];
        }

        

        groupBox.appendChild(groupInfo);
        groupInfo.appendChild(groupImgWrapper);
        groupImgWrapper.appendChild(groupImg);
        groupInfo.appendChild(groupNameLabel);
        groupInfo.appendChild(groupStats);
        groupStats.appendChild(groupTypeIcon);
        groupInfo.appendChild(premiumTag);
        groupInfo.appendChild(groupDescLabel);
        groupInfo.appendChild(groupLinkBtn);
        groupLinkBtn.appendChild(groupLinkImg);
        groupBox.appendChild(groupFollowBtn);

        if (addGroupSeparator)
        {
            let groupSep = document.createElement("div");
            groupSep.className = "group-box-large-separator noselect notap";

            groupBox.appendChild(groupSep);
        }

        theEl.appendChild(groupBox);
    }

    

    //Original Code
    function showMapPointsOnMobile(theKPID, move, animated, changeMeta)
    { 
        var listView = "";
        
        let theKP = pointStore[theKPID];
        
        selectedKPID = theKP.KPID;

        listView = listView + "<div id='kp-container-box-small' class='kp-container-box-small'>";
        
        if (theKP.mcActive === "Y")
        {
            if (theKP.mcFree === "Y")
            {
                listView = listView + "<div class='mc-header'>" + theKP.mcDiscount + words["DiscountOrFree"] + "</div>";

            } else
            {
                listView = listView + "<div class='mc-header'>" + theKP.mcDiscount + words["Discount"] + "</div>";
            }          

            mobileTouchBarDash.style.opacity = 0;

        } else
        {
            mobileTouchBarDash.style.opacity = 1;
        }
        
        listView = listView + "<div class='kp-container-box-content'>";
        
        if (theKP.saved === "Y")
        {
            listView = listView + "<div class='kp-save-mobile-btn point-saved clickable' onclick='savePoint(this, " + theKP.KPID + ", event)'><img src='img/bookmark-filled-icon.png' class='noselect notap'></div>";
            
        } else
        {
            listView = listView + "<div class='kp-save-mobile-btn point-not-saved clickable' onclick='savePoint(this, " + theKP.KPID + ", event)'><img src='img/bookmark-icon.png' class='noselect notap'></div>";
        }
        
        listView = listView + "<div class='kp-share-btn-small clickable' onclick='shareLink(\"" + theKP.pointLink + "\", false)'><img src='img/share-icon.png' class='noselect notap'></div>";
        listView = listView + "<div class='kp-point-details-small'>";
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

        /*
        if (theKP.updatedTime === theKP.timeCreated)
        {
            var kpDate = theKP.timeCreated.split(" ", 1);
            
            listView = listView + "<div id='kp-created-date' class='kp-created-date'>" + kpDate + "</div>";
            
        } else
        {
            var kpUpdateDate = theKP.updatedTime.split(" ", 1);
            
            listView = listView + "<div id='kp-created-date' class='kp-created-date'>" + words["Update"] + kpUpdateDate + "</div>";

        }
         */
        
        if (theKP.pointClass === "P")
        {
            listView = listView + "<div id='kp-premium-tag' class='kp-premium-tag'>" + words["Premium"] + "</div>";
        }
        
        listView = listView + "</div>";
        listView = listView + "</div>";
        
        if (theKP.topic.length > 0)
        {
            listView = listView + "<div id='kp-title-small' class='kp-title-small noselect'>" + theKP.topic + "</div>";
        }
        
        listView = listView + "</div>";
        listView = listView + "</div>";
        
        if (theKP.theKlicks.length > 1)
        {
            listView = listView + "<div id='kp-scrollmenu-small' class='kp-scrollmenu-small'>";
            
            theKP.theKlicks.forEach(function (aKlick) {
                           
                listView = listView + "<div class='kp-thumbnail-small'><img src='"+ s3Path + thumbnailFolder + aKlick.klickImgKey + ".jpg' class='noselect notap' onmousedown='return false' /></div>";
            });
            
            listView = listView + "</div>";
            
        } else
        {
            listView = listView + "<div class='kp-thumbnail-single-small'><img src='"+ s3Path + imageFolder + theKP.theKlicks[0].klickImgKey + ".jpg' class='noselect notap' onmousedown='return false' /></div>";
        }

        listView = listView + "</div>";
        listView = listView + "</div>";
        
        mobileMapPointContent.innerHTML = listView;

        listView = null;

        //set display to block to get mobileMapPointContent.clientHeight
        mobileMapPointContent.style.display = "block";
        
        listTopExistingY = contentWrapper.clientHeight - mobileMapPointContent.clientHeight;

        mobileSinglePointFrame.style.transition = "0.25s";
        mobileSinglePointFrame.style.top = listTopExistingY + "px";

        mobileSinglePointFrame.style.borderTopLeftRadius = "10px";
        mobileSinglePointFrame.style.borderTopRightRadius = "10px";

        listForMapPointVisible = true;
        
        if (pointListVisible)
        {
            pointListVisible = false;

            mobilePointListContent.style.opacity = 0;

            hideSingleListBtn.style.display = "none";
            bannerLogo.style.display = "table-cell";

        } else
        {
            if (toolBar.style.opacity > 0)
            {
                toolBar.style.opacity = 0;
            }
        }

        document.getElementById("kp-container-box-small").addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();
                                                                        
            showSingleList(theKPID, false, false, false);
                                                                       
        });

        if (move)
        {
            //Don't retrieve from server if the point is in the store
            if (pointStore[theKP.KPID])
            {
                reloadMap = false;
            }
            
            let latDiff = map.getBounds().getNorthWest().lat - map.getBounds().getSouthEast().lat;
            let adjustedLat = theKP.KPLat - (latDiff * 0.25);
                    
            if (animated)
            {
                map.flyTo({
                    center: [theKP.KPLng, adjustedLat],
                    essential: true,
                    speed: 1.5, // make the flying slow
                    curve: 1, // change the speed at which it zooms out
                    bearing: 0,

                    // This can be any easing function: it takes a number between
                    // 0 and 1 and returns another number between 0 and 1.
                    easing: function (t) {
                        return t;
                    }
                });
                
            } else
            {
                //Use current map zoom because adjustedLat is calculated based on that
                map.jumpTo({
                    center: [theKP.KPLng, adjustedLat],
                    zoom: map.getZoom(),
                    bearing: 0,
                });
            }
        }
                
        setTimeout(function()
        {
            mobileMapPointContent.style.opacity = 1;

            mobilePointListContent.style.display = "none";
            toolBar.style.display = "none";

            //When map doesn't reload
            //Update markers
            if (!move || pointStore[theKP.KPID])
            {
                markersOnMap.forEach(function (aMarker, markerKPID)
                {
                    let classList = aMarker.getElement().classList;
                                        
                    if (parseInt(markerKPID) === parseInt(selectedKPID))
                    {
                            if (classList.contains("marker-on-dir") === false)
                            {
                                classList.add("marker-on-dir");
                                classList.remove("marker-on");
                                classList.remove("marker");
                                classList.remove("marker-off");
                            }
                            
                    } else
                    {
                            if (classList.contains("marker-off") === false)
                            {
                                classList.add("marker-off");
                                classList.remove("marker-on-dir");
                                classList.remove("marker-on");
                                classList.remove("marker");
                            }
                    }
                                        
                });
            }

        }, 250);

        if (changeMeta)
        {
            changeMetaSettingsForKP(theKP);
        }
    }

    function refreshControlList(appendSearchOnly, transition, moveToTop)
    {
        let showFocusGroup = false;
        
        let listContent = "";
        
        if (userID > 0)
        {
            if (theFocusLinkGroup)
            {
                showFocusGroup = true;
            }
            
        } else
        {
            if (searchBar.value.trim().length === 0)
            {
                if (theFocusLinkGroup)
                {
                    showFocusGroup = true;
                }
            }
        }
        
        if (transition)
        {
            controlListContent.style.opacity = "0";
        }
        
        let theGroupIDs = [];
        let theOtherGroupIDs = [];
        
        if (showFocusGroup)
        {
            listContent = listContent + "<div class='group-box-large noselect' onclick='moveToGroupLoc(event, \"" + theFocusLinkGroup.groupID + "\", false)'>";
            listContent = listContent + "<div class='group-info noselect'>";
                   
            let groupImgPath = "";

            if (theFocusLinkGroup.groupImgKey.length > 0)
            {
                groupImgPath = s3Path + groupImageFolder + theFocusLinkGroup.groupImgKey + ".jpg";
              
            } else
            {
                groupImgPath = "img/group-default-img.png";
            }

            let groupImgBorderOn = "";

            if (theFocusLinkGroup.groupType === "O" || theFocusLinkGroup.groupRole === "C" || theFocusLinkGroup.groupRole === "A" || theFocusLinkGroup.groupRole === "M")
            {
                if (selectedGroups.indexOf(theFocusLinkGroup.groupID.toString()) > -1)
                {
                    groupImgBorderOn = "group-pic-border-on";
                } 
            }
                   
            listContent = listContent + "<div class='channel-group-pic-large " + groupImgBorderOn + " noselect'><img src='" + groupImgPath + "' class='noselect notap'/></div>";

            let groupTypeIcon = "<img src='img/channel-o-icon.png' class='group-type-icon'>";
            
            if (theFocusLinkGroup.groupType === "R")
            {
                groupTypeIcon = "<img src='img/channel-r-icon.png' class='group-type-icon'>";
                
            } else if (theFocusLinkGroup.groupType === "C")
            {
                groupTypeIcon = "<img src='img/channel-c-icon.png' class='group-type-icon'>";
            }
            
            listContent = listContent + "<div class='group-name-large noselect notap'>" + theFocusLinkGroup.groupName + "</div>";
            listContent = listContent + "<div class='group-stat noselect notap'>" + theFocusLinkGroup.noOfKPs + " " + words["Points"] + " • " + theFocusLinkGroup.noOfMembers + " " +  words["Followers"] + groupTypeIcon  + "</div>";
                   
            if (theFocusLinkGroup.premium === "Y")
            {
                listContent = listContent + "<div class='group-premium-tag-large noselect notap'>" + words["PremiumAvail"] + "</div>";
            }
                   
            if (theFocusLinkGroup.groupDesc.length > 0)
            {
                listContent = listContent + "<div class='group-mission noselect notap'>" + theFocusLinkGroup.groupDesc + "</div>";
            }
            
            listContent = listContent + "</div>";
                   
            listContent = listContent + "<div class='group-share-large-btn clickable noselect' onclick='shareLink(\"" + theFocusLinkGroup.link + "\", true)'><img src='img/share-icon.png' class='noselect notap'></div>";
            
            if (userID > 0)
            {
                if (theFocusLinkGroup.groupRole === "C" || theFocusLinkGroup.groupRole === "A")
                {
                    
                } else if (theFocusLinkGroup.groupRole === "M")
                {
                    listContent = listContent + "<div id='follow-group-btn' class='group-function-large-btn button-light-inverse clickable noselect' onclick='followGroup(this, " + theFocusLinkGroup.groupID + ", event)'>" + words["Following"] + "</div>";

                } else if (theFocusLinkGroup.groupRole === "R")
                {
                    listContent = listContent + "<div id='follow-group-btn' class='group-function-large-btn button-gray clickable noselect' onclick='followGroup(this, " + theFocusLinkGroup.groupID + ", event)'>" + words["Requested"] + "</div>";

                } else
                {
                    listContent = listContent + "<div id='follow-group-btn' class='group-function-large-btn button-light clickable noselect' onclick='followGroup(this, " + theFocusLinkGroup.groupID + ", event)'>" + words["Follow"] + "</div>";
                }
                               
            } else
            {
                listContent = listContent + "<div class='group-function-large-btn button-light clickable noselect' onclick='showLoginEvent(event)'>" + words["Follow"] + "</div>";
            }

            exitFocusChannelBtn.style.display = "block";
            controlListContent.style.paddingBottom = exitFocusChannelBtn.clientHeight + "px";

            listContent = listContent + "</div>";
            
        } else
        {
            if (!appendSearchOnly)
            {
                let groups = userGroups;
                
                if (searchBar.value.trim().length > 0)
                {
                    groups = followingSearchGroups;
                }
                
                if (userID > 0)
                {
                    //Arrange orders here
                    var theGroups = [];
                    
                    groups.forEach(function (theGroup) {
                    
                        var idx = selectedGroups.indexOf(theGroup.groupID.toString());

                        if (idx > -1)
                        {
                            //Put selected group at the top
                            theGroups.unshift(theGroup);
                                   
                        } else
                        {
                            theGroups.push(theGroup);
                        }
                    });
                    
                    if (searchTerm.length === 0 || theGroups.length > 0)
                    {
                        listContent = "<div class='group-list-separator noselect notap'>" + words["MyFollowing"] + "</div>";
                        
                        if (searchTerm.length === 0)
                        {
                            //GroupID 0 is for show the user's collection
                            if (selectedGroups[0] === "0")
                            {
                                listContent = listContent + "<div class='group-box group-box-selected noselect clickable' id='group_cell0' onclick='selectGroup(\"0\")'>";
                                
                            } else
                            {
                                listContent = listContent + "<div class='group-box noselect clickable' id='group_cell0' onclick='selectGroup(\"0\")'>";
                            }
                            
                            listContent = listContent + "<div class='bookmark-pic'><img src='img/bookmark-filled-icon.png' class='noselect notap' onmousedown='return false'/></div>";
                            listContent = listContent + "<div class='group-name noselect notap'>" + words["MyCollections"] + "</div>";
                            listContent = listContent + "</div>";
                            
                            theGroupIDs.push(0);
                        }
                    }

                    theGroups.forEach(function (theGroup) {
                                              
                        var idx = selectedGroups.indexOf(theGroup.groupID.toString());

                        if (idx > -1)
                        {
                            //Selected group cell
                            listContent = listContent + "<div class='group-box group-box-selected noselect clickable' id='group_cell" + theGroup.groupID + "' onclick='selectGroup(\"" + theGroup.groupID + "\")'>";
                                 
                        } else
                        {
                            listContent = listContent + "<div class='group-box noselect clickable' id='group_cell" + theGroup.groupID + "' onclick='selectGroup(\"" + theGroup.groupID + "\")'>";
                        }
                                      
                        let groupImgPath = "";

                        if (theGroup.groupImgKey.length > 0)
                        {
                            groupImgPath = s3Path + groupImageFolder + theGroup.groupImgKey + ".jpg";
                           
                        } else
                        {
                            groupImgPath = "img/group-default-img.png";
                        }

                        listContent = listContent + "<div class='noselect' onclick='setFocusGroup(event, \"" + theGroup.groupID + "\")'><img src='" + groupImgPath + "' class='group-pic noselect notap' onmousedown='return false'/></div>";
                                               
                        listContent = listContent + "<div class='group-name noselect notap'>" + theGroup.groupName + "</div>";
                        
                        if (parseFloat(theGroup.groupLng) != 0.0 || parseFloat(theGroup.groupLat) != 0.0)
                        {
                            listContent = listContent + "<div class='group-loc-btn noselect' onclick='moveToGroupLoc(event, \"" + theGroup.groupID + "\", true)'><img src='img/location.png' class='noselect notap'/></div>";
                                      
                        } else
                        {
                            listContent = listContent + "<div class='group-loc-btn noselect'><img src='img/location.png' class='noselect notap' style='opacity:0.35'/></div>";
                        }

                        listContent = listContent + "</div>";

                        theGroupIDs.push(theGroup.groupID);
                                      
                    });
                }
            }

            if (otherSearchGroups.length > 0 && (!appendSearchOnly || document.getElementById("group-list-separator") === null))
            {
                if (searchBar.value.trim().length === 0)
                {
                    listContent = listContent + "<div id='group-list-separator' class='group-list-separator noselect notap'>" + words["ChSuggestion"] + "</div>";
                    
                } else
                {
                    listContent = listContent + "<div id='group-list-separator' class='group-list-separator noselect notap'>" + words["SearchResults"] + "</div>";
                }
                
                otherSearchGroups.forEach(function (theGroup) {
                
                    listContent = listContent + "<div class='group-box-large noselect' onclick='moveToGroupLoc(event, \"" + theGroup.groupID + "\", false)'>";
                    listContent = listContent + "<div class='group-info noselect'>";
                          
                    let groupImgPath = "";

                    if (theGroup.groupImgKey.length > 0)
                    {
                        groupImgPath = s3Path + groupImageFolder + theGroup.groupImgKey + ".jpg";
                     
                    } else
                    {
                        groupImgPath = "img/group-default-img.png";
                    }

                    let groupImgBorderOn = "";

                    if (theGroup.groupType === "O" || theGroup.groupRole === "C" || theGroup.groupRole === "A" || theGroup.groupRole === "M")
                    {
                        if (selectedGroups.indexOf(theGroup.groupID.toString()) > -1)
                        {
                            groupImgBorderOn = "group-pic-border-on";
                        } 
                    }

                    listContent = listContent + "<div class='channel-group-pic-large " + groupImgBorderOn + " noselect'><img src='" + groupImgPath + "' class='noselect notap'/></div>";

                    let groupTypeIcon = "<img src='img/channel-o-icon.png' class='group-type-icon'>";

                    if (theGroup.groupType === "R")
                    {
                        groupTypeIcon = "<img src='img/channel-r-icon.png' class='group-type-icon'>";

                    } else if (theGroup.groupType === "C")
                    {
                        groupTypeIcon = "<img src='img/channel-c-icon.png' class='group-type-icon'>";
                    }

                    listContent = listContent + "<div class='group-name-large noselect notap'>" + theGroup.groupName + "</div>";
                    listContent = listContent + "<div class='group-stat noselect notap'>" + theGroup.noOfKPs + " " + words["Points"] + " • " + theGroup.noOfMembers + " " +  words["Followers"] + groupTypeIcon  + "</div>";
                          
                    if (theGroup.premium === "Y")
                    {
                        listContent = listContent + "<div class='group-premium-tag-large noselect notap'>" + words["PremiumAvail"] + "</div>";
                    }
                          
                   if (theGroup.groupDesc.length > 0)
                   {
                       listContent = listContent + "<div class='group-mission noselect notap'>" + theGroup.groupDesc + "</div>";
                   }
                   
                   listContent = listContent + "</div>";

                    listContent = listContent + "<div class='group-share-large-btn clickable noselect' onclick='shareLink(\"" + theGroup.link + "\", true)'><img src='img/share-icon.png' class='notap noselect'></div>";
                              

                    if (userID > 0)
                    {
                        if (theGroup.groupRole === "C" || theGroup.groupRole === "A")
                        {
                           
                        } else if (theGroup.groupRole === "M")
                        {
                            listContent = listContent + "<div id='follow-group-btn" + theGroup.groupID + "' class='group-function-large-btn button-light-inverse clickable noselect' onclick='followGroup(this, " + theGroup.groupID + ", event)'>" + words["Following"] + "</div>";
                                          
                        } else if (theGroup.groupRole === "R")
                        {
                            listContent = listContent + "<div id='follow-group-btn" + theGroup.groupID + "' class='group-function-large-btn button-gray clickable noselect' onclick='followGroup(this, " + theGroup.groupID + ", event)'>" + words["Requested"] + "</div>";

                        } else
                        {
                            listContent = listContent + "<div id='follow-group-btn" + theGroup.groupID + "' class='group-function-large-btn button-light clickable noselect' onclick='followGroup(this, " + theGroup.groupID + ", event)'>" + words["Follow"] + "</div>";
                        }

                    } else
                    {
                        listContent = listContent + "<div id='follow-group-btn" + theGroup.groupID + "' class='group-function-large-btn button-light clickable noselect' onclick='showLoginEvent(event)'>" + words["Follow"] + "</div>";
                    }
                                          
                    listContent = listContent + "<div class='group-box-large-separator noselect notap'></div>";
                               
                    listContent = listContent + "</div>";
                        
                    theOtherGroupIDs.push(theGroup.groupID);
                });
            }
        }
        
        let updateTime = 0;
        
        if (transition)
        {
            updateTime = 300;
        }
        
        setTimeout(function()
        {
            if (showFocusGroup)
            {
                controlListContent.innerHTML = listContent;
                   
            } else
            {
               if (!appendSearchOnly)
               {
                    controlListContent.innerHTML = listContent;
               
                   if (userID > 0)
                   {
                        groupCells.length = 0;
                  
                        theGroupIDs.forEach(function (theGroupID)
                        {
                            groupCells[theGroupID] = document.getElementById("group_cell" + theGroupID);
                        });
                   }
                   
               } else
               {
                   if (otherSearchGroups.length > 0 && document.getElementById("group-list-separator") === null)
                   {
                        controlListContent.insertAdjacentHTML("beforeend", listContent);
                   }
               }
            }
                   
            controlListContent.style.opacity = "1";
                   
            if (moveToTop)
            {
                controlListContent.scrollTop = 0;
            }
                   
        }, updateTime);
    }

?>
