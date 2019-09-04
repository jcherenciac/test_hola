<?php


namespace Tests\AppBundle\Services;


use AppBundle\Entity\User;
use AppBundle\Services\ApiService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ApiServicesTest extends TestCase
{

    public function testList(){

        $user = new User();
        $user->setName('testName');
        $user->setPassword('testPassword');

        $userRepository = $this->createMock(ObjectRepository::class);
        $userRepository->expects($this->any())
            ->method('findAll')
            ->willReturn([$user]);
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);
        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $apiservice = new ApiService($objectManagerMock,$serializerMock);
        $this->assertEquals([$user], $apiservice->list());
    }
    public function testGetReturnUser()
    {

        $user = new User();
        $user->setName('testName');
        $user->setPassword('testPassword');

        $userRepository = $this->createMock(ObjectRepository::class);
        $userRepository->expects($this->any())
            ->method('find')
            ->willReturn($user);
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);
        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $apiservice = new ApiService($objectManagerMock, $serializerMock);
        $this->assertEquals(200, $apiservice->get(1)['statusCode']);
    }
    public function testGetReturnUserNotFound()
    {
        $userRepository = $this->createMock(ObjectRepository::class);
        $userRepository->expects($this->any())
            ->method('find')
            ->willReturn(false);
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);
        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $apiservice = new ApiService($objectManagerMock,$serializerMock);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $apiservice->get(1)['statusCode']);
    }

    public function testCreateOk()
    {
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $data = [];
        $user = new User();
        $user->setName('testName');
        $user->setPassword('testPassword');

        $userRepository = $this->createMock(User::class);
        $userRepository->expects($this->any())
            ->method('isValid')
            ->willReturn(true);
        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $serializerMock->expects($this->any())
            ->method('deserialize')
            ->willReturn($userRepository);
        $apiservice = new ApiService($objectManagerMock,$serializerMock);
        $this->assertEquals(Response::HTTP_OK, $apiservice->create($data)['statusCode']);
    }
    public function testCreateInvalidUserData()
    {
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $data = [];
        $user = new User();
        $user->setName('testName');
        $user->setPassword('testPassword');

        $userRepository = $this->createMock(User::class);
        $userRepository->expects($this->any())
            ->method('isValid')
            ->willReturn(false);
        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $serializerMock->expects($this->any())
            ->method('deserialize')
            ->willReturn($userRepository);
        $apiservice = new ApiService($objectManagerMock,$serializerMock);
        $this->assertEquals(Response::HTTP_PARTIAL_CONTENT, $apiservice->create($data)['statusCode']);
    }

    public function testUpdateOk()
    {
        $data = [];
        $id = 1;
        $user = new User();
        $user->setName('testName');
        $user->setPassword('testPassword');

        $userRepository = $this->createMock(User::class);
        $userRepository->expects($this->any())
            ->method('isValid')
            ->willReturn(true);

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects($this->any())
            ->method('find')
            ->willReturn($user);
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects($this->any())
            ->method('getRepository')
            ->willReturn($objectRepository);

        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $serializerMock->expects($this->any())
            ->method('deserialize')
            ->willReturn($userRepository);
        $apiservice = new ApiService($objectManagerMock,$serializerMock);
        $this->assertEquals(Response::HTTP_OK, $apiservice->update($data,$id)['statusCode']);
    }
    public function testUpdateInvalidDataReturnError()
    {
        $data = [];
        $id = 1;
        $user = new User();
        $user->setName('testName');
        $user->setPassword('testPassword');

        $userRepository = $this->createMock(User::class);
        $userRepository->expects($this->any())
            ->method('isValid')
            ->willReturn(false);

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects($this->any())
            ->method('find')
            ->willReturn($user);
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects($this->any())
            ->method('getRepository')
            ->willReturn($objectRepository);

        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $serializerMock->expects($this->any())
            ->method('deserialize')
            ->willReturn($userRepository);
        $apiservice = new ApiService($objectManagerMock,$serializerMock);
        $this->assertEquals(Response::HTTP_PARTIAL_CONTENT, $apiservice->update($data,$id)['statusCode']);
    }
    public function testDeleteReturnOk()
    {

        $user = new User();
        $user->setName('testName');
        $user->setPassword('testPassword');

        $userRepository = $this->createMock(ObjectRepository::class);
        $userRepository->expects($this->any())
            ->method('find')
            ->willReturn($user);
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);
        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $apiservice = new ApiService($objectManagerMock, $serializerMock);
        $this->assertEquals(200, $apiservice->remove(1)['statusCode']);
    }
    public function testDeleteReturnUserNotFound()
    {
        $userRepository = $this->createMock(ObjectRepository::class);
        $userRepository->expects($this->any())
            ->method('find')
            ->willReturn(false);
        $objectManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);
        $serializerMock = $this->getMockBuilder('Symfony\Component\Serializer\SerializerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $apiservice = new ApiService($objectManagerMock,$serializerMock);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $apiservice->remove(1)['statusCode']);
    }

}