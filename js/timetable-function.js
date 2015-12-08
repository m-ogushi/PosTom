$.fn.showTimeTable = function(){

    var selector = $("<p/>")
           .attr("id","changeDateButton")
           .attr("data-role","controlgroup")
           .attr("data-type","horizontal")
           .attr("align","center")
           .addClass("ui-controlgroup-horizontal")
           .addClass("ui-controlgroup")
           .addClass("ui-corner-all");
    $(this).append(selector);
    $(this).append("<h3 align='center' id='sessionDate'></h3>");

    var group = $("<div/>").addClass("ui-controlgroup-controls");
    selector.append(group);

    for (var d in timetable){
        var dno = Number(d)+1;
        var day = $("<a/>")
                  .text(timetable[d].day)
                  .attr("href","#sessiontable"+dno)
                  .attr("data-role","button")
                  .addClass("sessiontable"+dno)
                  .addClass("ui-btn")
                  .addClass("ui-corner-all");

        if(dno<10){
            day.attr("id","changeDate0"+dno);
        }
        else{
            day.attr("id","changeDate"+dno);
        }
        group.append(day);
    }
    var tables = $("<div/>")
           .attr("id","sessiontables");
    $(this).append(tables);
//    Generate Time Table
    for (var d in timetable){
        var dno = Number(d)+1;
        var table_div = $("<div/>")
                        .attr("id","sessiontable"+dno)
                        .addClass("sessiontable");
        tables.append(table_div);

        var table = $("<table/>").addClass("session_table");
        table_div.append(table);

        table.append($("<thead/>"))
             .append("<tr><th>Time</th><th>Room</th><th>Session</th></tr>");
        var tbody = $("<tbody/>");
        var schedule = timetable[d].schedule;
        for(var sc in schedule){
            var parallel_size = Object.keys(schedule[sc].sessions).length;
            var slot_type = schedule[sc].type;
            var session_cnt = 0;
            for(var se in schedule[sc].sessions){
               var timeslot = $("<tr/>");
                if(session_cnt == 0){
                  var time = $("<th/>")
                             .addClass("shottime")
                             .attr("bgcolor","blue");
                  if(schedule[sc].time_display == "all"){
                    time.text(""+schedule[sc].start_time + "-" + schedule[sc].end_time);
                  }
                  else if(schedule[sc].time_display == "start_only"){
                    time.text(""+schedule[sc].start_time);
                  }
                  else if(schedule[sc].time_display == "no"){
                    time.text("");
                  }
                  if(parallel_size > 1){
                      time.attr("rowspan",schedule[sc].sessions.length);
                  }
                  timeslot.append(time);
                }
                var room = $("<td/>");
                if(schedule[sc].slot_type == "break"){
                   room.addClass("rest");
                }
                var roomname = $("<a/>")
                           .text(schedule[sc].sessions[se].room)
                           .addClass("jumpToVenue");
                room.append(roomname);
                timeslot.append(room);


                var session = $("<td/>");
                if(schedule[sc].sessions[se].sessionid!=""){
                    var sessionid = schedule[sc].sessions[se].sessionid;
                    var session_link = $("<a/>")
                            .text(session_map[sessionid].title)
                            .attr("id","presenLink"+sessionid)
                            .addClass("jumpToPresen");
                    session.append(session_link);
                }
                else{
                    session.text(schedule[sc].sessions[se].session_name);
                }

                if(schedule[sc].slot_type == "break"){
                    time.addClass("rest");
                    session.addClass("rest");
                }

                timeslot.append(session);

                session_cnt++;
                tbody.append(timeslot);
            }

        }
        table.append(tbody);


    }
 }
