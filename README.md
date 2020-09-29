Quick and dirty script to process weather data from NOAA and make a plot of "days at least 100/110 degrees by year"

https://www.ncdc.noaa.gov/cdo-web/

## Output

![alt text](./out.png)

## Usage

```
php overhundred.php
gnuplot plot.p
rsvg-convert out.svg -b -o out.png
```
