// DOM element where the Timeline will be attached
  var container1 = document.getElementById('visualization0');
  var container2 = document.getElementById('visualization1');
  var container3 = document.getElementById('visualization2');

  // Create a DataSet (allows two way data-binding)
  /*
  each element in a dataset must have unique id (?) not positive 
  group corresponds to the container group object, can be a string
  className allows you to customize specific items
  */
  var items = new vis.DataSet([
    {id: 1, content: 'item 1', start: '2014-04-20', group: 1, className: 'lecture'},
    {id: 2, content: 'item 2', start: '2014-04-14', group: 1, className: 'lecture'},
    {id: 3, content: 'item 3', start: '2014-04-18', group: 1, className: 'lecture'},
  ]);

  var itemsActivity = new vis.DataSet([
    {id: 4, content: 'item 4', start: '2014-04-16', end: '2014-04-19', group: 2, className: 'Activity'},
    {id: 5, content: 'item 5', start: '2014-04-25', group: 2, className: 'Activity'},
  ]);
  
  var itemsInterval = new vis.DataSet([
    {id: 6, content: 'item 6', start: '2014-04-27', type: 'point', group: 3, className: 'Interval'}
  ]);

  /* 
  content property is what is displayed on the timeline
  id property corresponds to the 'group' property of events
  */
  var groups = new vis.DataSet();
  groups.add({id: 1, content: 'Lecture'})

  var groupsActivity = new vis.DataSet();
  groupsActivity.add({id: 2, content: 'Activity'})

  var groupsInterval = new vis.DataSet();
  groupsInterval.add({id: 3, content: 'Interval'})

  // Configuration for the Timeline
  var options = {
  };

  // Create a Timeline
  var timeline1 = new vis.Timeline(container1, items, options);
  var timeline2 = new vis.Timeline(container2, itemsActivity, options);
  var timeline3 = new vis.Timeline(container3, itemsInterval, options);

  timeline1.on('rangechange', onrangechange1);
  timeline2.on('rangechange', onrangechange2);
  timeline3.on('rangechange', onrangechange3);

  
  function onrangechange1() {
    var range = timeline1.getWindow();
    timeline2.setWindow(range.start, range.end, {animation: false});
    timeline3.setWindow(range.start, range.end, {animation: false});
  }

  function onrangechange2() {
    var range = timeline2.getWindow();
    timeline1.setWindow(range.start, range.end, {animation: false});  
    timeline3.setWindow(range.start, range.end, {animation: false});


  }

  function onrangechange3() {
    var range = timeline3.getWindow();
    timeline1.setWindow(range.start, range.end, {animation: false});
    timeline2.setWindow(range.start, range.end, {animation: false});
  }

  timeline1.setGroups(groups);
  timeline2.setGroups(groupsActivity);
  timeline3.setGroups(groupsInterval);
  timeline1.setItems(items);
  timeline2.setItems(itemsActivity);
  timeline3.setItems(itemsInterval);

  var checkBox1 = document.getElementById("myCheck0");
  var checkBox2 = document.getElementById("myCheck1"); 
  var checkBox3 = document.getElementById("myCheck2");
  checkBox1.onchange = function () {
    container1.style.display = this.checked ? "none" : "block";
  }
  checkBox2.onchange = function () {
    container2.style.display = this.checked ? "none" : "block";
  }
  checkBox3.onchange = function () {
    container3.style.display = this.checked ? "none" : "block";
  }