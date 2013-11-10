AngularJS Directive for responsive Facebook Like Box
=============

This Angular module needs jQuery to work, `jqlite`  won't cut it.

Add the 'FB' module to your dependencies, use the directive like:

```html
<div style="width: 80%;">
  <div fb-like="http://example.com"></div>
</div>
``` 

The box will redraw itself if the window is resized, according to the parent. You can set more options using other attributes:

```html
<div style="width: 80%;">
  <div fb-like="http://example.com" fb-height="800" fb-faces="true" fb-stream="true" fb-header="true"></div>
</div>
``` 
