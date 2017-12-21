#requirement
    #powershell
    #yarn
    #node

    
$currentDir = (Get-Item -Path ".\" -Verbose).FullName
$packageName = "deployment-package"
$packageDir = '.\' + $packageName
$zipLocation = $currentDir+'/'+$packageName+'.zip'



#Remove previous package if any
if(Test-Path $packageDir) {
    Remove-Item $packageDir -Force -Recurse
}

#Create package dir
mkdir -p $packageDir
$toCopy = @()

$toCopy += @{
    from = '*';
    to = $packageDir;
    exclude = @(
        '.awcache',
        'node_modules',
        'vendor',
        'php-deployer',
        '.git',
        '.idea',
        $packageName,
        "$packageName.zip"
        'deployment'
    )
}

$toCopy += @{
    from = 'deployment';
    to = $packageDir+'/deployment';
    exclude = @(
        '.env',
        'webpack-path-base.config.js'
    )
}

$toCopy += @{
    from = 'deployment/webpack-path-base.config.js';
    to = $packageDir+'/webpack-path-base.config.js';
    exclude = @()
}

$toCopy += @{
    from = 'deployment/.env';
    to = $packageDir+'/.env';
    exclude = @()
}



foreach($copyConfig in $toCopy){
    #Copy all files/folders to deployment folder
    
    echo $copyConfig.to
    Copy-Item $copyConfig.from $copyConfig.to -Recurse -Exclude $copyConfig.exclude -Force
}


#custom specific
#apidoc -i $packageDir"/app" -o "$packageDir/public/apidoc"


cd $packageDir
yarn install
yarn run build

Remove-Item node_modules -Force -Recurse

cd $currentDir

Add-Type -assembly "system.io.compression.filesystem"

if(Test-Path $zipLocation){
    Remove-Item $zipLocation -Force
}

[io.compression.zipfile]::CreateFromDirectory("$currentDir/$packageName", $zipLocation)

Remove-Item $packageDir -Force -Recurse