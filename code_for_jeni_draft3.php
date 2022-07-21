<?php
//Objective

function showPointList(KPIDs, append, move)
{
    if (controlListVisible)
    {
        hideControlList(true);
        
    } else
    {
        let zoomLat;
            let zoomLng;
            
            let theKP;

            let listView = "";
            let pointView;
            
            if (append && !otherAreaKPsOnList)
            {
                let otherArea = document.createElement("div");
                otherArea.className = "kp-list-separator noselect notap";
                otherArea.innerHTML = "OtherAreas";
                
                listView.appendChild(otherArea);
                otherAreaKPsOnList = true;
                
            } else if (!append)
            {
                pointsOnList.length = 0;
                otherAreaKPsOnList = false;
            }
            
            for (let i = 0; i < KPIDs.length; i++)
            {
                pointView = "";

                theKP = pointStore[KPIDs[i]];
                
                pointsOnList[theKP.KPID] = theKP.KPID;
                
                let containerBox = document.createElement("div");
                containerBox.id = "kp-container-box-" + theKP.KPID;
                containerBox.className = "kp-container-box";
                
                pointView.appendChild(containerBox);
                
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
                }
                
                containerBox.appendChild(mcHeader);
                
                let boxContent = document.createElement("div");
                boxContent.className = "kp-container-box-content";
                
                let saveBtn = document.createElement("div");
                saveBtn.setAttribute("onclick", "savePoint(this, " + theKP.KPID + ", event)");
       
                let saveBtnImg = document.createElement("img");
                saveBtnImg.className = "noselect notap";
                
                if (theKP.saved === "Y")
                {
                    saveBtn.className =  "kp-save-btn point-saved clickable";
                    saveBtnImg.src = "img/bookmark-filled-icon.png";
                   
                } else 
                {
                    saveBtn.className = "kp-save-btn point-not-saved clickable";
                    saveBtnImg.src = "img/bookmark-icon.png";
                }
                
                saveBtn.appendChild(saveBtnImg);
                
                let shareBtn = document.createElement("div");
                shareBtn.className = "kp-share-btn clickable";
                shareBtn.setAttribute("onclick", "shareLink(\"" + theKP.pointLink + "\", false)");
                
                let shareBtnImg = document.createElement("img");
                shareBtnImg.src = "img/share-icon.png";
                shareBtnImg.className = "noselect notap";
                
                shareBtn.appendChild(shareBtnImg);
                
                let locBtn = document.createElement("div");
                locBtn.className = "kp-loc-btn clickable";
                
                let locBtnImg = document.createElement("img");
                locBtnImg.src = "img/location.png";
                locBtnImg.className = "noselect notap";
                
                if (mobile)
                {
                    locBtn.setAttribute("onclick", "showKPLocOnMobile(event, \"" + theKP.KPID + "\")");
                    
                } else
                {
                    locBtn.setAttribute("onclick", "centerKPLoc(event, \"" + theKP.KPID + "\")");
                    
                }
                
                locBtn.appendChild(locBtnImg);
                
                let pointDetails = document.createElement("div");
                pointDetails.className = "kp-point-details";
                
                let rowSection = document.createElement("div");
                rowSection.className = "row noselect";
                
                let userDetails = document.createElement("div");
                userDetails.className = "kp-user-details";
                
                var profilepicPath = "";
                
                if (theKP.profilePicKey.length > 0)
                {
                    profilepicPath = s3Path + profilePicFolder + theKP.profilePicKey + ".jpg";
                   
                } else
                {
                    profilepicPath = "img/user-default-img.png";
                }
                
                let profilePic = document.createElement("div");
                profilePic.id = "kp-user-profilepic";
                
                let profilePicImg = document.createElement("img");
                profilePicImg.src = profilepicPath;
                profilePicImg.className = "kp-user-profilepic noselect notap'";
                profilePicImg.setAttribute("onmousedown", "return false");
                
                profilePic.appendChild(profilePicImg);
                
                let userCol = document.createElement("div");
                userCol.className = "kp-username-col";
                
                let userName = document.createElement("div");
                userName.id = "kp-username";
                userName.className = "kp-username";
                userName.innerHTML = theKP.creatorName;
                
                let premiumTag = document.createElement("div");
                
                if (theKP.pointClass === "P")
                {
                    premiumTag.id = "kp-premium-tag";
                    premiumTag.className = "kp-premium-tag";
                    premiumTag.innerHTML = "Premium";

                }
                
                rowSection.appendChild(userDetails);
                userDetails.appendChild(profilePic);
                userDetails.appendChild(userCol);
                userCol.appendChild(userName);
                
                
                if (theKP.pointClass === "P")
                {
                    userCol.appendChild(premiumTag);
                }
                
                
                if (theKP.topic.length > 0)
                {
                    let topicTitle = document.createElement("div");
                    topicTitle.id = "kp-title";
                    topicTitle.className = "kp-title noselect";
                    topicTitle.innerHTML = theKP.topic;
                    
                    rowSection.appendChild(topicTitle);
                    
                }
                
                pointDetails.appendChild(rowSection);
                boxContent.appendChild(pointDetails);
                
                let thumbnailFrame = document.createElement("div");
                thumbnailFrame.id = "kp-thumbnails-frame-" + theKP.KPID;
                thumbnailFrame.className = "kp-thumbnails-frame clickable";
                
                let thumbnailPre = document.createElement("button");
                thumbnailPre.id = "pre-img-btn-" + theKP.KPID;
                thumbnailPre.className = "scroll-img-button pre-img-btn clickable";
                
                let thumbnailPreImg = document.create("img");
                thumbnailPreImg.src = "img/arrow-left.png";
                thumbnailPreImg.className = "noselect notap";
                
                thumbnailPre.appendChild(thumbnailPreImg);
                
                let thumbnailNext = document.createElement("button");
                thumbnailNext.id = "next-img-btn-" + theKP.KPID;
                thumbnailNext.className = "scroll-img-button scroll-img-button next-img-btn clickablee";
                
                let thumbnailNextImg = document.create("img");
                thumbnailNextImg.src = "img/arrow-right.png";
                thumbnailNextImg.className = "noselect notap";
                
                thumbnailNext.appendChild(thumbnailNextImg);
                
                let scrollMenu = document.createElement("div");
                scrollMenu.id = "kp-scrollmenu-" + theKP.KPID;
                scrollMenu.classname = "kp-scrollmenu";
                
                theKP.theKlicks.forEach(function (aKlick) {
                    
                    let thumbnail = document.createElement("div");
                    thumbnail.className = "kp-thumbnail";
              
                    let thumbnailImg = document.createElement("img");
                    thumbnailImg.src = s3Path + imageFolder + aKlick.klickImgKey + ".jpg";
                    thumbnailImg.className = "noselect notap";
                    thumbnailImg.setAttribute("onmousedown", "return false");
                    
                    thumbnail.appendChild(thumbnailImg);
                    scrollMenu.appendChild(thumbnail);
                               
                });
                
                boxContent.appendChild(saveBtn);
                boxContent.appendChild(shareBtn);
                boxContent.appendChild(locBtn);
                boxContent.appendChild(thumbnailFrame);
                thumbnailFrame.appendChild(thumbnailPre);
                thumbnailFrame.appendChild(thumbnailNext);
                containerBox.appendChild(boxContent);
                
                if (i === 0)
                {
                    let visibleLng = map.getBounds().getSouthEast().lng - map.getBounds().getNorthWest().lng;
                    let adjustLng = theKP.KPLng - (((pointList.clientWidth / 2) / contentWrapper.clientWidth) * visibleLng);

                    zoomLat = theKP.KPLat;
                    zoomLng = adjustLng;
                }

            }
            
            if (mobile)
            {
                //For mobilePointListContent.scrollTop to work
                mobilePointListContent.style.display = "block";
                mobilePointListContent.style.opacity = 1;

                mobileSinglePointFrame.style.borderTopLeftRadius = "0px";
                mobileSinglePointFrame.style.borderTopRightRadius = "0px";

                mobileTouchBarDash.style.opacity = 1;
            }

            if (append)
            {
                if (mobile)
                {
                    mobilePointListContent.insertAdjacentHTML("beforeend", listView);

                } else
                {
                    pointListContent.insertAdjacentHTML("beforeend", listView);
                }

            } else
            {
                if (mobile)
                {
                    mobilePointListContent.innerHTML = listView;
                    mobilePointListContent.scrollTop = 0;

                } else
                {
                    pointListContent.innerHTML = listView;
                    pointListContent.scrollTop = 0;
                }

                getMoreKPsForList = true;
            }
            
            if (mobile)
            {
                if (pointListVisible === false)
                {
                    listTopExistingY = 0;
                    mobileSinglePointFrame.style.top = listTopExistingY + "px";

                    if (mobileMapPointContent.style.opacity > 0)
                    {
                        mobileMapPointContent.style.opacity = 0;
                    }

                    if (toolBar.style.opacity > 0)
                    {
                        toolBar.style.opacity = 0;
                    }
                    
                    setTimeout(() => {
                        mobileMapPointContent.style.display = "none";
                        toolBar.style.display = "none";

                    }, 250);

                    pointListVisible = true;
                    listForMapPointVisible = false;
                }

            } else
            {
                toggleListBtn.style.opacity = "0";

                //Make sure the list has full opacity
                //PointList opacity set to 0 when map drag
                pointList.style.opacity = "1";
                pointList.style.left = "0px";

                pointListVisible = true;
                listForMapPointVisible = false;

                markersOnMap.forEach(function (aMarker, markerKPID)
                {
                    let classList = aMarker.getElement().classList;
                                    
                    if (selectedKPID > 0)
                    {
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
                                    
                    } else
                    {
                        if (pointsOnList[markerKPID])
                        {
                            if (classList.contains("marker-on") === false)
                            {
                                classList.add("marker-on");
                                classList.remove("marker-on-dir");
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
                    }
                });
                
                if (move)
                {
                    //Don't retrieve from server if the point is in the store
                    if (pointStore[theKP.KPID])
                    {
                        reloadMap = false;
                        
                    }
                    
                    map.flyTo({
                        center: [zoomLng, zoomLat],
                        essential: true,
                        speed: 1.5, // make the flying slow
                        curve: 1, // change the speed at which it zooms out

                        // This can be any easing function: it takes a number between
                        // 0 and 1 and returns another number between 0 and 1.
                        easing: function (t) {
                            return t;
                        }
                    });
                }
            }
                        
            for (var i = 0; i < KPIDs.length; i++)
            {
                let forKP = pointStore[KPIDs[i]];
                
                if (mobile)
                {
                    document.getElementById("kp-container-box-" + forKP.KPID).addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();
                                        
                        //Don't move map for mobile
                        showSingleList(forKP.KPID, false, true, true);
                                                                                           
                    });
                    
                } else
                {
                    document.getElementById("kp-thumbnails-frame-" + forKP.KPID).addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();
                                        
                        showSingleList(forKP.KPID, true, true, true);
                                                                                           
                    });
                    
                    document.getElementById("kp-thumbnails-frame-" + forKP.KPID).addEventListener('mouseover', e => {
                        e.preventDefault();
                        e.stopPropagation();
                      
                          markersOnMap.forEach(function (aMarker, markerKPID)
                          {
                              let classList = aMarker.getElement().classList;

                              if (parseInt(markerKPID) === parseInt(forKP.KPID))
                              {
                                   if (classList.contains("marker-on") === false)
                                   {
                                       classList.add("marker-on");
                                       classList.remove("marker-on-dir");
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
                                                                                                                                
                    });
                }
                
                let scroller = document.getElementById("kp-scrollmenu-" + forKP.KPID);
                scroller.scrollTo({"left": 0});
                
                document.getElementById("pre-img-btn-" + forKP.KPID).addEventListener('click', e => {
                    e.preventDefault();
                    e.stopPropagation();
                                                                               
                    let curPos = Math.floor(scroller.scrollLeft / (scroller.scrollWidth / forKP.theKlicks.length));
                                          
                    let targetPos;

                    if (curPos > 0)
                    {
                       targetPos = curPos - 1;
                                        
                    } else
                    {
                       targetPos = curPos;
                    }

                    let scrollLeft = Math.floor(scroller.scrollWidth * (targetPos / forKP.theKlicks.length));
                                                                                 
                    smoothScroll(scroller, scrollLeft, true);

                });
                
                document.getElementById("next-img-btn-" + forKP.KPID).addEventListener('click', e => {
                    e.preventDefault();
                    e.stopPropagation();

                    let curPos = Math.floor(scroller.scrollLeft / (scroller.scrollWidth / forKP.theKlicks.length));
                                          
                    let targetPos;

                    if (curPos < (forKP.theKlicks.length - 1))
                    {
                       targetPos = curPos + 1;
                                        
                    } else
                    {
                       targetPos = curPos;
                    }

                    let scrollLeft = Math.floor(scroller.scrollWidth * (targetPos / forKP.theKlicks.length));
                                                                                 
                    smoothScroll(scroller, scrollLeft, true);
                                                                            
                });
            }
    }
}

//Original Code
    function showPointList(KPIDs, append, move)
    {
        if (controlListVisible)
        {
            hideControlList(true);
            
        } else
        {
                
            let zoomLat;
            let zoomLng;
            
            let theKP;

            let listView = "";
            let pointView;
            
            if (append && !otherAreaKPsOnList)
            {
                listView = "<div class='kp-list-separator noselect notap'>" + words["OtherAreas"] + "</div>";
                
                otherAreaKPsOnList = true;
                
            } else if (!append)
            {
                pointsOnList.length = 0;
                otherAreaKPsOnList = false;
            }
            
            for (let i = 0; i < KPIDs.length; i++)
            {
                pointView = "";

                theKP = pointStore[KPIDs[i]];
                
                pointsOnList[theKP.KPID] = theKP.KPID;

                pointView = pointView + "<div id='kp-container-box-" + theKP.KPID + "' class='kp-container-box'>";
                
                if (theKP.mcActive === "Y")
                {
                    if (theKP.mcFree === "Y")
                    {
                        pointView = pointView + "<div class='mc-header'>" + theKP.mcDiscount + words["DiscountOrFree"] + "</div>";

                    } else
                    {
                        pointView = pointView + "<div class='mc-header'>" + theKP.mcDiscount + words["Discount"] + "</div>";
                    }  
                }
                
                pointView = pointView + "<div class='kp-container-box-content'>";
                
                if (theKP.saved === "Y")
                {
                    pointView = pointView + "<div class='kp-save-btn point-saved clickable' onclick='savePoint(this, " + theKP.KPID + ", event)'><img src='img/bookmark-filled-icon.png' class='noselect notap'></div>";
                    
                } else
                {
                    pointView = pointView + "<div class='kp-save-btn point-not-saved clickable' onclick='savePoint(this, " + theKP.KPID + ", event)'><img src='img/bookmark-icon.png' class='noselect notap'></div>";
                }
                
                pointView = pointView + "<div class='kp-share-btn clickable' onclick='shareLink(\"" + theKP.pointLink + "\", false)'><img src='img/share-icon.png' class='noselect notap'></div>";
                
                if (mobile)
                {
                    pointView = pointView + "<div class='kp-loc-btn clickable' onclick='showKPLocOnMobile(event, \"" + theKP.KPID + "\")'><img src='img/location.png' class='noselect notap'></div>";

                } else
                {
                    pointView = pointView + "<div class='kp-loc-btn clickable' onclick='centerKPLoc(event, \"" + theKP.KPID + "\")'><img src='img/location.png' class='noselect notap'></div>";
                }
                
                pointView = pointView + "<div class='kp-point-details'>";
                pointView = pointView + "<div class='row noselect'>";
                pointView = pointView + "<div class='kp-user-details'>";
                
                var profilepicPath = "";
                
                if (theKP.profilePicKey.length > 0)
                {
                    profilepicPath = s3Path + profilePicFolder + theKP.profilePicKey + ".jpg";
                   
                } else
                {
                    profilepicPath = "img/user-default-img.png";
                }
                
                pointView = pointView + "<div id='kp-user-profilepic'><img src='" + profilepicPath + "' class='kp-user-profilepic noselect notap' onmousedown='return false' /></div>";
                pointView = pointView + "<div class='kp-username-col'>";
                pointView = pointView + "<div id='kp-username' class='kp-username''>" + theKP.creatorName + "</div>";
                                
                if (theKP.pointClass === "P")
                {
                    pointView = pointView + "<div id='kp-premium-tag' class='kp-premium-tag'>Premium</div>";
                }
                
                pointView = pointView + "</div>";
                pointView = pointView + "</div>";
                
                if (theKP.topic.length > 0)
                {
                    pointView = pointView + "<div id='kp-title' class='kp-title noselect'>" + theKP.topic + "</div>";
                }
                
                pointView = pointView + "</div>";
                pointView = pointView + "</div>";
                
                
                pointView = pointView + "<div id='kp-thumbnails-frame-" + theKP.KPID + "' class='kp-thumbnails-frame clickable'>";
                pointView = pointView + "<button id='pre-img-btn-" + theKP.KPID + "' class='scroll-img-button pre-img-btn clickable'><img src='img/arrow-left.png' class='noselect notap'/></button><button id='next-img-btn-" + theKP.KPID + "' class='scroll-img-button scroll-img-button next-img-btn clickable'><img src='img/arrow-right.png' class='noselect notap'/></button>";

                pointView = pointView + "<div id='kp-scrollmenu-" + theKP.KPID + "' class='kp-scrollmenu'>";
                
                theKP.theKlicks.forEach(function (aKlick) {
                               
                    pointView = pointView + "<div class='kp-thumbnail'><img src='"+ s3Path + imageFolder + aKlick.klickImgKey + ".jpg' class='noselect notap' onmousedown='return false' /></div>";
                });
                
                pointView = pointView + "</div>";
                        
                pointView = pointView + "</div>";
                pointView = pointView + "</div>";
                pointView = pointView + "</div>";
                
                if (parseInt(selectedKPID) === parseInt(KPIDs[i]))
                {
                    listView = pointView + listView;

                } else
                {
                    listView = listView + pointView;
                }

                if (i === 0)
                {
                    let visibleLng = map.getBounds().getSouthEast().lng - map.getBounds().getNorthWest().lng;
                    let adjustLng = theKP.KPLng - (((pointList.clientWidth / 2) / contentWrapper.clientWidth) * visibleLng);

                    zoomLat = theKP.KPLat;
                    zoomLng = adjustLng;
                }
            }

            if (mobile)
            {
                //For mobilePointListContent.scrollTop to work
                mobilePointListContent.style.display = "block";
                mobilePointListContent.style.opacity = 1;

                mobileSinglePointFrame.style.borderTopLeftRadius = "0px";
                mobileSinglePointFrame.style.borderTopRightRadius = "0px";

                mobileTouchBarDash.style.opacity = 1;
            }

            if (append)
            {
                if (mobile)
                {
                    mobilePointListContent.insertAdjacentHTML("beforeend", listView);

                } else
                {
                    pointListContent.insertAdjacentHTML("beforeend", listView);
                }

            } else
            {
                if (mobile)
                {
                    mobilePointListContent.innerHTML = listView;
                    mobilePointListContent.scrollTop = 0;

                } else
                {
                    pointListContent.innerHTML = listView;
                    pointListContent.scrollTop = 0;
                }

                getMoreKPsForList = true;
            }
            
            if (mobile)
            {
                if (pointListVisible === false)
                {
                    listTopExistingY = 0;
                    mobileSinglePointFrame.style.top = listTopExistingY + "px";

                    if (mobileMapPointContent.style.opacity > 0)
                    {
                        mobileMapPointContent.style.opacity = 0;
                    }

                    if (toolBar.style.opacity > 0)
                    {
                        toolBar.style.opacity = 0;
                    }
                    
                    setTimeout(() => {
                        mobileMapPointContent.style.display = "none";
                        toolBar.style.display = "none";

                    }, 250);

                    pointListVisible = true;
                    listForMapPointVisible = false;
                }

            } else
            {
                toggleListBtn.style.opacity = "0";

                //Make sure the list has full opacity
                //PointList opacity set to 0 when map drag
                pointList.style.opacity = "1";
                pointList.style.left = "0px";

                pointListVisible = true;
                listForMapPointVisible = false;

                markersOnMap.forEach(function (aMarker, markerKPID)
                {
                    let classList = aMarker.getElement().classList;
                                    
                    if (selectedKPID > 0)
                    {
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
                                    
                    } else
                    {
                        if (pointsOnList[markerKPID])
                        {
                            if (classList.contains("marker-on") === false)
                            {
                                classList.add("marker-on");
                                classList.remove("marker-on-dir");
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
                    }
                });
                
                if (move)
                {
                    //Don't retrieve from server if the point is in the store
                    if (pointStore[theKP.KPID])
                    {
                        reloadMap = false;
                        
                    }
                    
                    map.flyTo({
                        center: [zoomLng, zoomLat],
                        essential: true,
                        speed: 1.5, // make the flying slow
                        curve: 1, // change the speed at which it zooms out

                        // This can be any easing function: it takes a number between
                        // 0 and 1 and returns another number between 0 and 1.
                        easing: function (t) {
                            return t;
                        }
                    });
                }
            }
                        
            for (var i = 0; i < KPIDs.length; i++)
            {
                let forKP = pointStore[KPIDs[i]];
                
                if (mobile)
                {
                    document.getElementById("kp-container-box-" + forKP.KPID).addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();
                                        
                        //Don't move map for mobile
                        showSingleList(forKP.KPID, false, true, true);
                                                                                           
                    });
                    
                } else
                {
                    document.getElementById("kp-thumbnails-frame-" + forKP.KPID).addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();
                                        
                        showSingleList(forKP.KPID, true, true, true);
                                                                                           
                    });
                    
                    document.getElementById("kp-thumbnails-frame-" + forKP.KPID).addEventListener('mouseover', e => {
                        e.preventDefault();
                        e.stopPropagation();
                      
                          markersOnMap.forEach(function (aMarker, markerKPID)
                          {
                              let classList = aMarker.getElement().classList;

                              if (parseInt(markerKPID) === parseInt(forKP.KPID))
                              {
                                   if (classList.contains("marker-on") === false)
                                   {
                                       classList.add("marker-on");
                                       classList.remove("marker-on-dir");
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
                                                                                                                                
                    });
                }
                
                let scroller = document.getElementById("kp-scrollmenu-" + forKP.KPID);
                scroller.scrollTo({"left": 0});
                
                document.getElementById("pre-img-btn-" + forKP.KPID).addEventListener('click', e => {
                    e.preventDefault();
                    e.stopPropagation();
                                                                               
                    let curPos = Math.floor(scroller.scrollLeft / (scroller.scrollWidth / forKP.theKlicks.length));
                                          
                    let targetPos;

                    if (curPos > 0)
                    {
                       targetPos = curPos - 1;
                                        
                    } else
                    {
                       targetPos = curPos;
                    }

                    let scrollLeft = Math.floor(scroller.scrollWidth * (targetPos / forKP.theKlicks.length));
                                                                                 
                    smoothScroll(scroller, scrollLeft, true);

                });
                
                document.getElementById("next-img-btn-" + forKP.KPID).addEventListener('click', e => {
                    e.preventDefault();
                    e.stopPropagation();

                    let curPos = Math.floor(scroller.scrollLeft / (scroller.scrollWidth / forKP.theKlicks.length));
                                          
                    let targetPos;

                    if (curPos < (forKP.theKlicks.length - 1))
                    {
                       targetPos = curPos + 1;
                                        
                    } else
                    {
                       targetPos = curPos;
                    }

                    let scrollLeft = Math.floor(scroller.scrollWidth * (targetPos / forKP.theKlicks.length));
                                                                                 
                    smoothScroll(scroller, scrollLeft, true);
                                                                            
                });
            }
        }
    }

?>
