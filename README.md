video_cinematic
===============

video_cinematic is an oxwall plugin. Video Cinematic Mode allow your oxwall video player has ability to dimm the light around and center the video.

Developing
----------

    git clone https://github.com/ycicom/video_cinematic.git
    
### Making plugin package from source

    cd /path/to/video_cinematic
    ./make-pkg.sh

Contributing
------------

Any contributing is appreciated. I need help in translating into other languages.

Changes Log
-----------

### 1.01.0

*   option to switch between presets: lite(thin border, no close button, no logo mark) and full (thick border with close button and logo mark)
*   re-wrote plugin structure (organized static contents)
*   added setting allows admins to display logo on video cinematic layer
*   allow admins changing border color

### 1.0.02

*   added a close cinematic mode button as requested

### 1.0.01

*   correctly restore z-index css attribute of video div layer when closing cinematic mode

### 1.0.0

*   Initial version
